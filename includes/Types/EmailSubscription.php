<?php
/**
 * Extension Abstract
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Types;

use SurfAlert\Extensions\GlobalFields;
use SurfAlert\GetInstance;
use SurfAlert\Modules;

/**
 * Extension Abstract for all Extension.
 * @method static EmailSubscription get_instance($args = null)
 */
class EmailSubscription extends Types {
    /**
     * Instance of Admin
     *
     * @var Admin
     */
	use GetInstance;

    public $priority = 65;
    public $is_pro = true;
    public $module = [
        'modules_mailchimp',
        'modules_convertkit',
        'modules_mailchimp',
        'modules_zapier',
    ];
    public $default_source    = 'mailchimp';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
        $this->id = 'email_subscription';
    }

    /**
     * Runs when modules is enabled.
     *
     * @return void
     */
    public function init(){
        parent::init();
        $this->title = __('Email Subscription', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/mailchimp-email-subscription-alert/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>Show popups to display which users subscribed to your Newsletter.</span>
                <video id="pro_alert_video_popup" type="text/html" allowfullscreen width="450" height="235" autoplay loop muted>
                    <source src="https://surfalert.com/wp-content/uploads/2024/01/How-to-Display-Email-Subscription-Alerts-using-SurfAlert.mp4" type="video/mp4">
                </video>
            ', 'surfalert')
        ];

        $common_fields = [
            'first_param'         => 'tag_first_name',
            'custom_first_param'  => __('Someone' , 'surfalert'),
            'second_param'        => __('just subscribed to', 'surfalert'),
            'third_param'         => 'tag_title',
            'custom_third_param'  => __('Anonymous Title', 'surfalert'),
            'fourth_param'        => 'tag_time',
            'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
        ];

        $this->themes = [
            'theme-one'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/subscriptions/mailchimp-theme-1.jpg',
                'image_shape' => 'rounded',
                'template' => $common_fields,
            ],
            'theme-two'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/subscriptions/mailchimp-theme-2.png',
                'template' => $common_fields,
                'image_shape' => 'circle',
            ],
            'theme-three' => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/subscriptions/mailchimp-theme-three.jpg',
                'image_shape' => 'square',
                'template' => $common_fields,
            ],
            'maps_theme'  => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/subscriptions/maps-theme-subscribed.png',
                'image_shape' => 'square',
                'show_notification_image' => 'maps_image',
            ],
        ];

        $this->res_themes = [
            'res-theme-one'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_subscriptions/mailchimp-res-theme-1.png',
                '_template' => 'mailchimp_template_new',
                'is_pro'    => true,
            ],
            'res-theme-two'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_subscriptions/mailchimp-res-theme-2.png',
                '_template' => 'mailchimp_template_new',
                'is_pro'    => true,
            ],
            'res-theme-three' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_subscriptions/mailchimp-res-theme-3.png',
                '_template' => 'mailchimp_template_new',
                'is_pro'    => true,
            ],
            'subscriptions-res-theme-four'  => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_subscriptions/mailchimp-res-theme-4.png',
                '_template' => 'maps_template_new',
                'is_pro'    => true,
            ],
        ];

        $this->templates = [
            'mailchimp_template_new' => [
                'first_param' => GlobalFields::get_instance()->common_name_fields(),
                'third_param' => [
                    'tag_title'           => __('List Title', 'surfalert'),
                    // 'tag_anonymous_title' => __('Anonymous Title' , 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_time' => __('Definite Time', 'surfalert'),
                    'tag_sometime' => __('Some time ago', 'surfalert'),
                ],
                '_themes' => [
                    "{$this->id}_theme-one",
                    "{$this->id}_theme-two",
                    "{$this->id}_theme-three",
                    "{$this->id}_maps_theme",
                ],
            ],
        ];
    }

    public function preview_entry($entry, $settings){
        $entry = array_merge($entry, [
            "title"             => "SurfAlert Pro",
        ]);

        if('email_subscription_maps_theme' !== $settings['theme']){
            $entry['image_data'] = array(
                'url'     => SURFALERT_PUBLIC_URL . 'image/icons/pink-face-looped.gif',
                'alt'     => '',
                'classes' => 'greview_icon',
            );
        }
        return $entry;
    }

}
