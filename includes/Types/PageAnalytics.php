<?php
/**
 * Extension Abstract
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Types;
use SurfAlert\GetInstance;
use SurfAlert\Modules;

/**
 * Extension Abstract for all Extension.
 * @method static PageAnalytics get_instance($args = null)
 */
class PageAnalytics extends Types {
    /**
     * Instance of Admin
     *
     * @var Admin
     */
	use GetInstance;

    public $priority = 70;
    public $is_pro = true;
    public $module = ['modules_google_analytics'];
    public $default_source    = 'google';


    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
        $this->id = 'page_analytics';
    }

    /**
     * Runs when modules is enabled.
     *
     * @return void
     */
    public function init(){
        parent::init();
        $this->title = __('Page Analytics', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/google-analytics/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>Connect Google Analytics to display the total number of real-time site visitors</span>
                <video id="pro_alert_video_popup" type="text/html" allowfullscreen width="450" height="235" autoplay loop muted>
                    <source src="https://surfalert.com/wp-content/uploads/2024/01/Google-Analytics-Integration-With-SurfAlert-How-To-Show-Active-Users-Traffic-in-WordPress.mp4" type="video/mp4">
                </video>
            ', 'surfalert')
        ];
        $this->themes = [
            'pa-theme-one'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/analytics/ga-theme-one.jpg',
                'template' => [
                    'first_param'        => 'tag_siteview',
                    'second_param'       => __('marketers', 'surfalert'),
                    'third_param'        => 'ga_title',
                    'custom_third_param' => __('Surfed this page', 'surfalert'),
                    'ga_fourth_param'    => __('in last ', 'surfalert'),
                    'ga_fifth_param'     => __('30', 'surfalert'),
                    'sixth_param'        => 'tag_day',
                ],
                'defaults'                => [
                    'link_button'        => false,
                    'link_type'          => 'none',
                    'show_default_image' => true,
                ],
            ],
            'pa-theme-two'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/analytics/pa-theme-one.png',
                'image_shape' => 'rounded',
                'template' => [
                    'first_param'        => 'tag_siteview',
                    'second_param'       => __('people visited', 'surfalert'),
                    'third_param'        => 'ga_title',
                    'custom_third_param' => __('this page', 'surfalert'),
                    'ga_fourth_param'    => __('in last ', 'surfalert'),
                    'ga_fifth_param'     => __('1', 'surfalert'),
                    'sixth_param'        => 'tag_day',
                ],
                'defaults'                => [
                    'link_button'        => false,
                    'link_type'          => 'none',
                    'show_default_image' => true,
                ],
            ],
            'pa-theme-three' => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/analytics/pa-theme-two.png',
                'image_shape' => 'circle',
                'template' => [
                    'first_param'        => 'tag_realtime_siteview',
                    'second_param'       => __('people looking', 'surfalert'),
                    'third_param'        => 'ga_title',
                    'custom_third_param' => __('this deal', 'surfalert'),
                    'ga_fourth_param'    => __('right now', 'surfalert'),
                    // need to set this two param unless they won't show up when changing the first param.
                    'ga_fifth_param'     => __('30', 'surfalert'),
                    'sixth_param'        => 'tag_day',
                ],
                'defaults'                => [
                    'link_button'      => false,
                    'link_type'        => 'none',
                    'show_default_image' => true,
                ],
            ],
            'pa-theme-four' => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/analytics/pa-theme-four.png',
                'image_shape' => 'circle',
                'template' => [
                    'first_param'        => 'tag_current_page_view',
                    'second_param'       => __('People Is Now Visiting', 'surfalert'),
                    'third_param'        => 'tag_custom',
                    'custom_third_param' => __('Holiday Deal Page', 'surfalert'),
                    'ga_fourth_param'    => __('Check out now & grab exceptional deals', 'surfalert'),
                    // need to set this two param unless they won't show up when changing the first param.
                    'ga_fifth_param'     => __('30', 'surfalert'),
                    'sixth_param'        => 'tag_day',
                ],
                'defaults'                => [
                    'link_button_text'   => __('Grab Now','surfalert'),
                    'link_button'        => true,
                    'link_type'          => 'custom',
                    'custom_url'         => '#',
                    'show_default_image' => true,
                ],
            ],
        ];
        $this->res_themes = [
            'res-pa-theme-one'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_analytics/ga-res-theme-1.png',
                'is_pro' => true,
            ],
            'res-pa-theme-two'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_analytics/ga-res-theme-2.png',
                'is_pro' => true,
            ],
            'res-pa-theme-three' => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_analytics/ga-res-theme-3.png',
                'is_pro' => true,
            ],
            'res-pa-theme-four' => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_analytics/ga-res-theme-4.png',
                'is_pro' => true,
            ],
        ];
        $this->templates = [
            'pa_template_new' => [
                'first_param' => [
                    'tag_siteview'          => __('Total Site View', 'surfalert'),
                    'tag_realtime_siteview' => __('Realtime site view', 'surfalert')
                ],
                'third_param' => [
                    'ga_title'  => __('Site Title', 'surfalert'),
                ],
                'sixth_param' => [
                    'tag_day'   => __('Day', 'surfalert'),
                    'tag_month' => __('Month', 'surfalert'),
                    'tag_year'  => __('Year', 'surfalert'),
                ],
                '_themes' => [
                    'page_analytics_pa-theme-one',
                    'page_analytics_pa-theme-two',
                    'page_analytics_pa-theme-three',
                ],
            ],
            'pa_template_current_page_view' => [
                'first_param' => [
                    'tag_current_page_view' => __('Current Page View', 'surfalert')
                ],
                'third_param' => [
                    'tag_ga_page_title'  => __('Page Title', 'surfalert'),
                ],
                'sixth_param' => [
                    'tag_day'   => __('Day', 'surfalert'),
                    'tag_month' => __('Month', 'surfalert'),
                    'tag_year'  => __('Year', 'surfalert'),
                ],
                '_themes' => [
                    'page_analytics_pa-theme-four',
                ],
            ],
        ];
    }

    public function preview_entry($entry, $settings){
        $entry = array_merge($entry, [
            "title"             => "WPDeveloper",

        ]);
        return $entry;
    }


}
