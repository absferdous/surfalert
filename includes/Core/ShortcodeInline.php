<?php
namespace SurfAlert\Core;

use SurfAlert\Core\PostType;
use SurfAlert\FrontEnd\FrontEnd;
use SurfAlert\GetInstance;

/**
 * Class Shortcode For SurfAlert
 * @method static ShortcodeInline get_instance($args = null)
 *
 * @since 1.2.3
 */
class ShortcodeInline {
    /**
     * Instance of ShortcodeInline
     *
     * @var ShortcodeInline
     */
    use GetInstance;

    public $shortcode_sa_ids = [];

    /**
     * __construct__ is for revoke first time to get ready
     *
     * @return void
     */
    public function __construct() {
        add_shortcode( 'surfalert_inline', array( $this, 'shortcode_inline' ), 999 );
        add_filter('sa_inline_notifications_data',array( $this, 'sa_inlineshortcode' ),10,4);
    }

    public function sa_inlineshortcode( $return, $source, $id, $settings ){
        if( !empty( $settings['shortcodeinline'] ) ) {
            return FrontEnd::get_instance()->get_notifications_data(
                array(
                    'shortcode'        => [$settings['sa_id']],
                    'inline_shortcode' => true,
                )
            );
        }
        return $return;
    }

    /**
     * this method is responsible for output the shortcode.
     *
     * @param array $atts
     */
    public function shortcode_inline( $atts, $content = null ) {
        $atts  = shortcode_atts( array(
            'id'            => '',
            'product_id'    => '',
            'post_type'     => '',
            'show_link'     => true,
            ), $atts, 'surfalert_inline'
        );

        $sa_id = $atts['id'];

        if ( empty( $sa_id ) ) {
            if ( ! current_user_can( 'administrator' ) ) {
                return;
            }
            return '<p class="sa-shortcode-notice">' . __( 'Choose a Notification from the dropdown.', 'surfalert-pro' ) . '</p>';
        }

        if ( ! PostType::get_instance()->is_enabled( $sa_id ) ) {
            if ( ! current_user_can( 'administrator' ) ) {
                return;
            }
            return '<p class="sa-shortcode-notice">' . __( 'Make sure you have enabled the notification which ID you have given.', 'surfalert-pro' ) . '</p>';
        }

        do_action( 'sa_inline' );
        $settings = PostType::get_instance()->get_post($sa_id);
        if( $settings['type'] == 'inline' || $settings['source'] == 'woocommerce_sales_inline' ){
            $settings['shortcodeinline'] = true;
            /**
             * @var WooInline|EDDInline
             */
            $extension = \SurfAlert\Extensions\ExtensionFactory::get_instance()->get($settings['source']);
            $output = $extension->show_inline_notification( $atts, $settings);
            if( !empty( $output ) ) {
                $output = "<div id='surfalert-shortcode-inline-{$atts['id']}' class='surfalert-shortcode-inline-wrapper sa-shortcode-notice'>$output</div>";
            }
            return $output;
        }

        $result = FrontEnd::get_instance()->get_notifications_data( [ 'shortcode' => [ $sa_id ] ] );

        $output = '';
        if ( ! empty( $result['shortcode'][ $sa_id ]['entries'] ) ) {
            $entries  = $result['shortcode'][ $sa_id ]['entries'];
            $entries  = array_values( $entries );
            $settings = $result['shortcode'][ $sa_id ]['post'];

            $logged_in       = is_user_logged_in();
            $show_on_display = isset($settings['show_on_display']) ? $settings['show_on_display'] : '';
            if ( ! ( ( $logged_in && 'logged_out_user' === $show_on_display ) || ( ! $logged_in && 'logged_in_user' === $show_on_display ) ) ) {

                $col = array_column( $entries, 'timestamp' );
                if ( count( $col ) == count( $entries ) ) {
                    array_multisort( $col, SORT_ASC, $entries );
                }
                $entry     = end( $entries );
                $template  = Inline::get_instance()->get_template( $settings );
                $_template = $template;

                foreach ( $entry as $key => $val ) {
                    if ( ! is_array( $val ) ) {
                        if ( 'rating' === $key ) {
                            $count = $val;
                            $val   = "<span style='white-space: nowrap'>";
                            for ( $i = 1; $i <= 5; $i++ ) {
                                $val .= $i <= $count
                                ? '<span style="color:#ffc107">★</span>'
                                : '<span style="color:#eeeeee">★</span>';
                            }
                            $val .= '</span>';
                        } elseif (
                            ! empty( $entry['link'] ) &&
                            in_array( $key, [ 'plugin_name', 'product_title', 'post_title', 'plugin_theme_name', 'course_title', 'title' ], true ) &&
                            'form' !== $settings['type'] &&
                            'email_subscription' !== $settings['type'] &&
                            'page_analytics' !== $settings['type']
                        ) {
                            $link   = $entry['link'];
                            $target = ! empty( $settings['link_open'] ) ? 'target="_blank"' : '';
                            if ( 'false' === $atts['show_link'] ) {
                                $target = '';
                                $link   = 'javascript:void(0)';
                            }
                            $val = "<a href='$link' $target>$val</a>";
                        }
                        $_template = str_replace( "{{{$key}}}", $val, $_template );
                    }
                    if ( ! empty( $entry['timestamp'] ) && strpos( $_template, '{{time}}' ) !== false ) {
                        $timestamp = $entry['timestamp'];
                        if ( $timestamp ) {
                            $diff_for_humans = sprintf(
                                /* translators: time */
                                _x( '%s ago', 'Inline Shortcode', 'surfalert-pro' ),
                                human_time_diff( $timestamp )
                            );
                            $_template = str_replace( '{{time}}', $diff_for_humans, $_template );
                        }
                    }
                }
                $output .= $_template;
                // $this->shortcode_sa_ids[] = $atts['id'];
                $output = "<div id='surfalert-shortcode-inline-{$atts['id']}' class='surfalert-shortcode-inline-wrapper sa-shortcode-notice'>$output</div>";
            }
        }

        return $output;
    }

}
