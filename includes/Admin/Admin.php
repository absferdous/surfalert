<?php

/**
 * Admin Class File.
 *
 * @package SurfAlert\Admin
 */

namespace SurfAlert\Admin;

use SurfAlert\Admin\Rating\RatingEmail;
use SurfAlert\SurfAlert;
use SurfAlert\Admin\Reports\ReportEmail;
use SurfAlert\Admin\Scanner\Scanner;
use SurfAlert\Core\Analytics;
use SurfAlert\Core\Dashboard;
use SurfAlert\Core\Database;
use SurfAlert\Core\PostType;
use SurfAlert\Core\Upgrader;
use SurfAlert\GetInstance;
use SurfAlert\Extensions\ExtensionFactory;

use PriyoMukul\WPNotice\Notices;
use PriyoMukul\WPNotice\Utils\CacheBank;
use PriyoMukul\WPNotice\Utils\NoticeRemover;

/**
 * Admin Class, this class is responsible for all Admin Actions
 * @method static Admin get_instance($args = null)
 */
class Admin
{
    /**
     * Instance of Admin
     *
     * @var Admin
     */
    use GetInstance;
    /**
     * Assets Path and URL
     */
    const ASSET_URL  = SURFALERT_ASSETS . 'admin/';
    const ASSET_PATH = SURFALERT_ASSETS_PATH . 'admin/';
    const VIEWS_PATH = SURFALERT_INCLUDES . 'Admin/views/';

    private $insights = null;

    /**
     * @var CacheBank
     */
    private static $cache_bank;

    /**
     * Initially Invoked
     * when its initialized.
     */
    public function __construct()
    {
        /**
         * Admin Dashboard Widget
         * For Analytics
         */
        Analytics::get_instance();
        ReportEmail::get_instance();
        RatingEmail::get_instance();
        ImportExport::get_instance();
        XSS::get_instance();
        add_action('init', [$this, 'init'], 5);
    }

    /**
     * This method is reponsible for Admin Menu of
     * SurfAlert
     *
     * @return void
     */
    public function init()
    {
        if (! SurfAlert::is_pro()) {
            $this->plugin_usage_insights();
            $this->admin_notices();
        }
        add_action('admin_init', [$this, 'admin_init']);
        add_action('admin_menu', [$this, 'menu'], 10);
        Dashboard::get_instance();
        PostType::get_instance();
        Settings::get_instance()->init();
        Entries::get_instance();
        Scanner::get_instance();
    }

    /**
     * This method is responsible for Admin Menu of
     * SurfAlert
     *
     * @return void
     */
    public function admin_init()
    {
        DashboardWidget::get_instance();
        add_action('in_admin_header', [$this, 'hide_others_plugin_admin_notice'], 99);
    }

    /**
     * This method is reponsible for Admin Menu of
     * SurfAlert
     *
     * @return void
     */
    public function menu()
    {
        add_menu_page(
            'SurfAlert',
            'SurfAlert',
            'read_surfalert', // User Permision.
            'sa-admin',
            array($this, 'views'),
            self::ASSET_URL . 'images/logo-icon.svg',
            80
        );
        add_submenu_page('sa-admin', __('All SurfAlert', 'surfalert'), __('All SurfAlert', 'surfalert'), 'read_surfalert', 'sa-admin', null, 1);
    }

    /**
     * Admin Views
     *
     * @return void
     */
    public function views()
    {
        // react script included in PostType::admin_enqueue_scripts();
        include_once Admin::VIEWS_PATH . 'main.views.php';
    }
    /**
     * Get File Modification Time or URL
     *
     * @param string $file  File relative path for Admin
     * @param boolean $url  true for URL return
     * @return void|string|integer
     */
    public function file($file, $url = false)
    {
        if ($url) {
            return self::ASSET_URL . $file;
        }
        return filemtime(self::ASSET_PATH . $file);
    }

    /**
     * This method is responsible for re generating notification for single type.
     * @param string $current_url
     * @since 1.4.0
     */
    public function regenerate_notifications($params)
    {
        $post_id = intval($params['sa_id']);
        // @todo should not query the settings here. source and other two should be passed in param.
        $post = PostType::get_instance()->get_post($post_id);
        $source = isset($post['source']) ? $post['source'] : false;
        $extension = ExtensionFactory::get_instance()->get($source);
        if (!empty($extension) && method_exists($extension, 'get_notification_ready') && $extension->is_active()) {
            Entries::get_instance()->delete_entries($post_id);
            $result = $extension->get_notification_ready($post, $post_id);
            return true;
        }
        return false;
    }

    /**
     * This method is responsible for re generating notification for single type.
     * @param string $current_url
     * @since 1.4.0
     */
    public function reset_notifications($params)
    {
        $sa_id = null;
        if (!empty($entry_key)) {
            $sa_id = $params['entry_key'];
        }
        if (!empty($params['sa_id'])) {
            $sa_id = $params['sa_id'];
        }
        if (!empty($sa_id)) {
            return Analytics::get_instance()->delete_analytics($sa_id);
        }
    }



    public function admin_notices()
    {
        self::$cache_bank = CacheBank::get_instance();
        try {
            // $this->notices();
        } catch (\Exception $e) {
            unset($e);
        }
        // Remove OLD notice from 1.0.0 (if other WPDeveloper plugin has notice)
        NoticeRemover::get_instance('1.0.0');
    }


    public function hide_others_plugin_admin_notice()
    {
        $current_screen = get_current_screen();
        $hide_on = ['toplevel_page_sa-admin', 'surfalert_page_sa-dashboard', 'surfalert_page_sa-edit', 'surfalert_page_sa-settings', 'surfalert_page_sa-analytics', 'surfalert_page_sa-builder'];
        if ($current_screen && isset($current_screen->base) &&  in_array($current_screen->base, $hide_on)) {
            remove_all_actions('user_admin_notices');
            remove_all_actions('admin_notices');
        }
    }

    public function notices()
    {
        $notices = new Notices([
            'id'             => 'surfalert',
            'store'          => 'options',
            'storage_key'    => 'notices',
            'version'        => '1.0.0',
            'lifetime'       => 3,
            'stylesheet_url' => '',
            'styles'         => self::ASSET_URL . 'css/wpdeveloper-review-notice.css',
            'priority'       => 7,
            // 'dev_mode'       => true
        ]);

        $_review_notice = [
            'thumbnail' => self::ASSET_URL . 'images/sa-icon.svg',
            'html' => '<p>' . __('We hope you\'re enjoying SurfAlert! Could you please do us a BIG favor and give it a 5-star rating on WordPress to help us spread the word and boost our motivation?', 'surfalert') . '</p>',
            'links' => [
                'later' => array(
                    'link' => 'https://wpdeveloper.com/review-surfalert',
                    'target' => '_blank',
                    'label' => __('Ok, you deserve it!', 'surfalert'),
                    'icon_class' => 'dashicons dashicons-external',
                ),
                'allready' => array(
                    'label' => __('I already did', 'surfalert'),
                    'icon_class' => 'dashicons dashicons-smiley',
                    'attributes' => [
                        'data-dismiss' => true
                    ],
                ),
                'maybe_later' => array(
                    'label' => __('Maybe Later', 'surfalert'),
                    'icon_class' => 'dashicons dashicons-calendar-alt',
                    'attributes' => [
                        'data-later' => true
                    ],
                ),
                'support' => array(
                    'link' => 'https://wpdeveloper.com/support',
                    'label' => __('I need help', 'surfalert'),
                    'icon_class' => 'dashicons dashicons-sos',
                ),
                'never_show_again' => array(
                    'label' => __('Never show again', 'surfalert'),
                    'icon_class' => 'dashicons dashicons-dismiss',
                    'attributes' => [
                        'data-dismiss' => true
                    ],
                )
            ]
        ];

        $notices->add(
            'review',
            $_review_notice,
            [
                'start'       => $notices->strtotime('+7 day'),
                'recurrence'  => 30,
                'dismissible' => true,
                'refresh'     => SURFALERT_VERSION,
            ]
        );

        $notices->add(
            'opt_in',
            [$this->insights, 'notice'],
            [
                'classes'     => 'updated put-dismiss-notice',
                'start'       => $notices->strtotime('+30 days'),
                'dismissible' => true,
                'refresh'     => SURFALERT_VERSION,
                'do_action'   => 'wpdeveloper_notice_clicked_for_surfalert',
                'display_if'  => ! is_array($notices->is_installed('surfalert-pro/surfalert-pro.php'))
            ]
        );

        $notice_text = sprintf('<div style="display: flex; align-items: center;">%s <a class="button button-primary" style="margin-left: 10px; background: #5614d5; border-color: #5614d5;" target="_blank" href="%s">%s</a></div>', __('<p><strong>Black Friday Exclusive:</strong> SAVE up to 40% & access to <strong>SurfAlert Pro</strong> features.</p>', 'surfalert'), esc_url('https://surfalert.com/#pricing'), __('Grab The Offer', 'surfalert'));

        $_black_friday = [
            'thumbnail' => self::ASSET_URL . 'images/sa-icon.svg',
            'html' => $notice_text,
        ];

        $notices->add(
            'black_friday',
            $_black_friday,
            [
                'start'       => $notices->time(),
                'recurrence'  => false,
                'dismissible' => true,
                'expire'      => strtotime('Wed, 30 Nov 2022 23:59:59 GMT'),
                'display_if'  => ! is_array($notices->is_installed('surfalert-pro/surfalert-pro.php'))
            ]
        );


        // New Notice
        $b_message            = '<p>6th Anniversary Sale: Unlock premium features with <strong>up to 25% discounts</strong> & skyrocket your conversions 🚀</p><a class="button button-primary" href="https://wpdeveloper.com/upgrade/surfalert-bfcm" target="_blank">Upgrade to PRO</a>';
        $_black_friday_notice = [
            'thumbnail' => self::ASSET_URL . 'images/full-logo.svg',
            'html'      => $b_message,
        ];

        $notices->add(
            '6th_anniversary',
            $_black_friday_notice,
            [
                'start'       => $notices->time(),
                'recurrence'  => false,
                'dismissible' => true,
                'refresh'     => SURFALERT_VERSION,
                "expire"      => strtotime('11:59:59pm 20th September, 2024'),
                // 'display_if'  => ! is_plugin_active( 'surfalert-pro/surfalert-pro.php' )
            ]
        );

        $crown = self::ASSET_URL . 'images/crown.svg';
        // Back Friday 2024
        $notice_text = "<p>🛍️ This Black Friday, enjoy <strong>up to 35% OFF</strong> on SurfAlert PRO and unlock exclusive marketing strategies.</p><a style='display: inline-flex;column-gap:5px;' class='button button-primary' href='https://surfalert.com/bfcm24-pricing' target='_blank'><img style='width:15px;' src='{$crown}'/>Upgrade to pro</a>";
        $_black_friday_2024 = [
            'thumbnail' => self::ASSET_URL . 'images/full-logo.svg',
            'html'      => $notice_text,
        ];
        $notices->add(
            'sa_black_friday_2024',
            $_black_friday_2024,
            [
                'start'       => $notices->time(),
                'recurrence'  => false,
                'dismissible' => true,
                'refresh'     => SURFALERT_VERSION,
                'screens'     => ['dashboard'],
                "expire"      => strtotime('11:59:59pm 5th December, 2024'),
                'display_if'  => !is_array($notices->is_installed('surfalert-pro/surfalert-pro.php'))
            ]
        );

        // Holiday Deal
        $notice_text = "<p>🎁 <strong>SAVE 25% now</strong> & unlock advanced social-proof marketing features to skyrocket conversions in 2025.</p>
                        <div class='sa-notice-action-button'>
                            <a style='display: inline-flex;column-gap:5px;' class='button button-primary' href='https://surfalert.com/holiday24-admin-notice' target='_blank'>
                                <img style='width:15px;' src='{$crown}'/>GET PRO Lifetime Access
                            </a>
                            <a class='sa-notice-action-dismiss dismiss-btn' data-dismiss='true' href='#'>
                                <img style='width:15px;' src='{$crown}'/>No, I'll Pay Full Price Later
                            </a>
                        </div>
                        ";
        $_holidays_deal = [
            'thumbnail' => self::ASSET_URL . 'images/full-logo.svg',
            'html'      => $notice_text,
        ];
        $notices->add(
            'sa_holidays_deal',
            $_holidays_deal,
            [
                'start'       => $notices->time(),
                'recurrence'  => false,
                'dismissible' => true,
                'refresh'     => SURFALERT_VERSION,
                'screens'     => ['dashboard'],
                "expire"      => strtotime('11:59:59pm 10th January, 2025'),
                // 'display_if'  => !is_array( $notices->is_installed( 'surfalert-pro/surfalert-pro.php' ) )
            ]
        );

        // $notices->init();
        self::$cache_bank->create_account($notices);
        self::$cache_bank->calculate_deposits($notices);
    }

    public function plugin_usage_insights()
    {
        $this->insights = PluginInsights::get_instance(SURFALERT_FILE, [
            'opt_in'       => true,
            'goodbye_form' => true,
            'item_id'      => '6ba8d30bc0beaddb2540'
        ]);
        $this->insights->set_notice_options(array(
            'notice' => __('Want to help make <strong>SurfAlert</strong> even more awesome? You can get a <strong>10% discount coupon</strong> for Premium extensions if you allow us to track the usage.', 'surfalert'),
            'extra_notice' => __('We collect non-sensitive diagnostic data and plugin usage information.
			Your site URL, WordPress & PHP version, plugins & themes and email address to send you the
			discount coupon. This data lets us make sure this plugin always stays compatible with the most
			popular plugins and themes. No spam, I promise.', 'surfalert'),
        ));
        $this->insights->init();
    }
}
