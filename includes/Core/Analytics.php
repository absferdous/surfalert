<?php

namespace SurfAlert\Core;

use SurfAlert\Admin\Admin;
use SurfAlert\Admin\Settings;
use SurfAlert\GetInstance;

/**
 * @method static Analytics get_instance($args = null)
 */
class Analytics {
    /**
     * Instance of Analytics
     *
     * @var Analytics
     */
    use GetInstance;

    /**
     *
     *
     * @var string
     */
    public static $date_format = 'Y-m-d';

    /**
     * Initially Invoked when initialized.
     *
     * @hook init
     */
    public function __construct() {
        // add_filter('get_notifications_ids', [$this, 'insert_views'], 999, 2);
        add_filter( 'sa_filtered_data', [ $this, 'insert_views' ], 999, 2 );
        add_action( 'admin_menu', [ $this, 'menu' ], 30 );
    }

    /**
     * This method is responsible for Admin Menu of
     * SurfAlert
     *
     * @return void
     */
    public function menu() {
        if ( Settings::get_instance()->get( 'settings.enable_analytics', true ) ) {
            add_submenu_page( 'sa-admin', __( 'Analytics', 'surfalert' ), __( 'Analytics', 'surfalert' ), 'read_surfalert_analytics', 'sa-analytics', [ Admin::get_instance(), 'views' ], 3 );
        }
    }

    public function get_stats( $args = [] ) {
        $where = [];
        $args  = wp_parse_args( $args, [] );
        if ( ! empty( $args['startDate'] ) && ! empty( $args['endDate'] ) ) {
            $start_date          = date( self::$date_format, strtotime( $args['startDate'] ) );
            $end_date            = date( self::$date_format, strtotime( $args['endDate'] ) );
            $where['created_at'] = [ 'BETWEEN', $start_date, $end_date ];
        }
        $stats = Database::get_instance()->get_posts( Database::$table_stats, '*', $where );
        $posts = PostType::get_instance()->get_posts( [], 'DISTINCT sa_id, title, source, theme' );
        return [
            'stats' => $stats,
            'posts' => $posts,
        ];
    }

    // Wrapper function for Database functions.
    public function insert_analytics( $sa_id, $type = 'clicks' ) {
        if ( ! $this->should_count() ) {
            return false;
        }
        $format = 'Y-m-d';
        $stats  = $this->stats_exists([
            'sa_id'      => $sa_id,
            'created_at' => date( self::$date_format, time() ),
        ]
        );
        if ( empty( $stats ) ) {
            $data = [
                'sa_id'  => $sa_id,
                'clicks' => $type == 'clicks' ? 1 : 0,
                'views'  => 1,
            ];
            $this->_insert_analytics( $data, time() );
        } else {
            $this->increment_count( $type, $sa_id, date( self::$date_format, time() ) );
        }
    }

    public function _insert_analytics( $data, $time = null, $migration = false ) {
        if ( ! $time ) {
            $time = time();
        }
        if ( $migration ) {
            $_data = $data;
            $sa_id = $_data['sa_id'];
            $stats = $this->stats_exists([
                'sa_id'      => $sa_id,
                'created_at' => date( self::$date_format, $time ),
            ]
            );
            if ( ! empty( $stats ) ) {
                unset( $_data['sa_id'] );
                foreach ( $_data as $_type => $_s_data ) {
                    $this->increment_count( $_type, $sa_id, date( self::$date_format, $time ), $_s_data );
                }
                return;
            }
        }
        $data['created_at'] = date( self::$date_format, $time );
        Database::get_instance()->insert_post( Database::$table_stats, $data );
    }

    public function migrate_analytics( $rows ) {
        if ( ! empty( $rows ) ) {
            $stats = Database::get_instance()->insert_posts( Database::$table_stats, $rows );
            return $stats;
        }
        return false;
    }

    public function delete_analytics($where__or_sa_id, $limit = 0) {
        if (!is_array($where__or_sa_id)) {
            $where__or_sa_id = ['sa_id' => $where__or_sa_id];
        }
        Database::get_instance()->delete_posts(Database::$table_stats, $where__or_sa_id, $limit);
        $analytics = $this->get_total_count();
        return $analytics;
    }

    public function stats_exists( $where = [] ) {
        $stats = Database::get_instance()->get_col( Database::$table_stats, 'stat_id', $where );
        return $stats;
    }

    public function increment_count( $type, $sa_id, $date, $_data = null ) {
        return Database::get_instance()->update_analytics( $type, $sa_id, $date, $_data );
    }

    public function get_count( $sa_id, $type ) {
        $where = [ 'sa_id' => absint( $sa_id ) ];
        $stats = Database::get_instance()->get_col( Database::$table_stats, $type, $where );
        if ( ! empty( $stats[0] ) ) {
            return $stats[0];
        }
        return 0;
    }

    public function get_total_count() {
        $stats = Database::get_instance()->get_posts( Database::$table_stats, 'SUM(views) AS totalViews, SUM(clicks) AS totalClicks' );
        if ( ! empty( $stats[0] ) ) {
            \extract( $stats[0] );
            return [
                'totalViews'  => Helper::nice_number( $totalViews ),
                'totalClicks' => Helper::nice_number( $totalClicks ),
                'totalCtr'    => $totalViews > 0 ? round( ( $totalClicks / $totalViews ) * 100, 2 ) : 0,
            ];
        }
        return 0;
    }

    /**
     * @todo maybe optimize in future. so that db can be updated in one request.
     *
     * @param [type] $entries
     * @param [type] $post
     * @return void
     */
    public function insert_views( $entries, $post ) {
        if ( ! did_action( 'sa_ignore_analytics' ) ) {
            $this->insert_analytics( $post['sa_id'], 'views' );
        }
        return $entries;
    }

    /*
     public function insert_views($sa_ids_array){
        $sa_ids = array_merge($sa_ids_array['global'], $sa_ids_array['active']);
        $this->insert_post($sa_ids, 'views');
        return $sa_ids_array;
    } */

    public function should_count() {
        global $user_ID;
        $should_count          = false;
        $exclude_bot_analytics = Settings::get_instance()->get( 'settings.exclude_bot_analytics', false );
        $analytics_from        = Settings::get_instance()->get( 'settings.analytics_from', false );
        $analytics_from        = empty( $analytics_from ) ? 'everyone' : $analytics_from;

        /**
         * Inspired from WP-Postviews for
         * this pece of code.
         */
        switch ( $analytics_from ) {
            case 'everyone':
                $should_count = true;
                break;
            case 'guests':
                if ( empty( $_COOKIE[ USER_COOKIE ] ) && (int) $user_ID === 0 ) {
                    $should_count = true;
                }
                break;
            case 'registered_users':
                if ( (int) $user_ID > 0 ) {
                    $should_count = true;
                }
                break;
        }

        if ( $should_count && $exclude_bot_analytics ) {
            /**
             * Inspired from WP-Postviews for
             * this piece of code.
             */
            $bots      = array(
                'Google Bot'    => 'google',
                'MSN'           => 'msnbot',
                'Alex'          => 'ia_archiver',
                'Lycos'         => 'lycos',
                'Ask Jeeves'    => 'jeeves',
                'Altavista'     => 'scooter',
                'AllTheWeb'     => 'fast-webcrawler',
                'Inktomi'       => 'slurp@inktomi',
                'Turnitin.com'  => 'turnitinbot',
                'Technorati'    => 'technorati',
                'Yahoo'         => 'yahoo',
                'Findexa'       => 'findexa',
                'NextLinks'     => 'findlinks',
                'Gais'          => 'gaisbo',
                'WiseNut'       => 'zyborg',
                'WhoisSource'   => 'surveybot',
                'Bloglines'     => 'bloglines',
                'BlogSearch'    => 'blogsearch',
                'PubSub'        => 'pubsub',
                'Syndic8'       => 'syndic8',
                'RadioUserland' => 'userland',
                'Gigabot'       => 'gigabot',
                'Become.com'    => 'become.com',
                'Baidu'         => 'baiduspider',
                'so.com'        => '360spider',
                'Sogou'         => 'spider',
                'soso.com'      => 'sosospider',
                'Yandex'        => 'yandex',
            );
            $useragent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
            foreach ( $bots as $name => $lookfor ) {
                if ( ! empty( $useragent ) && ( false !== stripos( $useragent, $lookfor ) ) ) {
                    $should_count = false;
                    break;
                }
            }
        }

        return $should_count;
    }

}
