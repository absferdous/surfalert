<?php

/**
 * Extension Abstract
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Types;

use SurfAlert\Core\Rule;
use SurfAlert\Core\Rules;
use SurfAlert\Extensions\ExtensionFactory;
use SurfAlert\Extensions\GlobalFields;
use SurfAlert\GetInstance;
use SurfAlert\Modules;

/**
 * Extension Abstract for all Extension.
 * @method static GDPR get_instance($args = null)
 */
class GDPR extends Types {
    /**
     * Instance of GDPR
     *
     * @var GDPR
     */
    use GetInstance;

    public $priority = 10;
    public $themes = [];
    public $module = [
        'modules_gdpr',
    ];
    public $default_source = 'gdpr_notification';
    public $sa_has_permission = true;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct() {
        parent::__construct();
        $this->id    = 'gdpr';
    }

    public function init()
    {
        parent::init();
        $this->title = __('Cookie Notice', 'surfalert');
        // sa_comment_colored_themes
        $this->themes = [
            'theme-light-one'        => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-light-1.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_title',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', false),
            ],
            'theme-light-two'        => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-light-2.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_title',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', false),
            ],
            'theme-light-three'      => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-light-3.png',
                'image_shape' => 'square',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_title',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', false),
            ],
            'theme-light-four'   => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-light-4.png',
                'image_shape' => 'rounded',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', false),
            ],
            'theme-dark-one'   => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-dark-1.png',
                'image_shape' => 'rounded',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', true),
            ],
            'theme-dark-two'   => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-dark-2.png',
                'image_shape' => 'rounded',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', true),
            ],
            'theme-dark-three'   => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-dark-3.png',
                'image_shape' => 'rounded',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', true),
            ],
            'theme-dark-four'   => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-dark-4.png',
                'image_shape' => 'rounded',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', true),
            ],
            'theme-banner-light-one' => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-banner-light-1.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', false),
            ],
            'theme-banner-light-two' => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-banner-light-2.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', false),
            ],
            'theme-banner-dark-one' => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-banner-dark-1.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', true),
            ],
            'theme-banner-dark-two' => [
                'source'  => 'https://surfalert.com/wp-content/uploads/2025/01/gdpr-banner-dark-2.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
                'rules'                   => Rules::is('gdpr_theme', true),
            ],
        ];
    }

    /**
     * Hooked to sa_before_metabox_load action.
     *
     * @return void
     */
    public function init_fields() {
        parent::init_fields();
        add_filter('sa_content_gdpr', [$this, 'add_content_fields'], 9);
        add_filter('sa_content_fields', [$this, '__add_content_fields'], 9);
        add_filter('sa_customize_fields', array($this, 'customize_fields'), 999);
    }

    public function customize_fields( $fields ) {
        $fields[] = [
            'label'  => __("Visibility", 'surfalert'),
            'name'   => "visibility",
            'type'   => "section",
            'rules'     => Rules::is('type', 'gdpr'),
            'priority'=> 10,
            'fields' => [
                [
                    'label' => __("Show On", 'surfalert'),
                    'name'  => "cookie_visibility_show_on",
                    'type'  => "select",
                    'default' => 'default',
                    'options'  => [
                        'default' => [
                            'label'    => __('Show Everywhere', 'surfalert'),
                            'value'    => 'default',
                            'selected' => 'selected',
                        ],
                    ]
                ],
                [
                    'label' => __("Display For", 'surfalert'),
                    'name'  => "cookie_visibility_display_for",
                    'type'  => "select",
                    'default' => 'default',
                    'options'  => [
                        'default' => [
                            'label'    => __('Everyone', 'surfalert'),
                            'value'    => 'default',
                            'selected' => 'selected',
                        ],
                    ]
                ],
                [
                    'label' => __("Delay Before Appearance", 'surfalert'),
                    'name'  => "cookie_visibility_delay_before",
                    'type'  => "text",
                    'default' => 5,
                    'description' => __("Seconds", "surfalert"),
                    'help'  => __("Initial Delay", "surfalert"),
                ],
            ]
        ];

        return $fields;
    }

    public function __add_content_fields( $fields ) {
        $_fields = &$fields;
        $_fields['preference_center'] = [
            'name'     => "preference_center",
            'type'     => "section",
            'priority' => 98,
            'label'    => 'Preference Center',
            'rules'     => Rules::is('type', 'gdpr'),
            'fields'   => [
                [
                    'label' => __("Title", 'surfalert'),
                    'name'  => "preference_title",
                    'type'  => "text",
                    'placeholder' => __("Title", 'surfalert'),
                    'default' => __("Customized Cookie Preferences", 'surfalert'),
                ],
                [
                    'label' => __("Privacy Overview", 'surfalert'),
                    'name'  => "preference_overview",
                    'type'  => "textarea",
                    'placeholder' => __("Privacy Overview", 'surfalert'),
                    'default' => __("We use cookies and similar technologies to enhance your experience and analyze site usage. Manage your preferences to control which data is collected.", 'surfalert'),
                ],
                [
                    'label' => __("Show Google Privacy Policy", 'surfalert'),
                    'name'  => "preference_google",
                    'type'  => "toggle",
                    'default' => false,
                    'info' => __("If you use services offered by Google, such as AdSense, Firebase, and Analytics on your website, the Digital Markets Act (DMA) requires you to display Google's Privacy Policy on the second layer of your banner.", 'surfalert'),
                ],
                [
                    'label' => __("Message", 'surfalert'),
                    'name'  => "preference_google_message",
                    'type'  => "textarea",
                    'placeholder' => __("Message", 'surfalert'),
                    'default' => __("To learn more about how Google's third-party cookies function and manage your data, read from here.", 'surfalert'),
                    'rules' => Rules::logicalRule([
                        Rules::is('preference_google', true),
                    ]),
                ],
                [
                    'label' => __("Link text", 'surfalert'),
                    'name'  => "preference_google_Link_text",
                    'type'  => "text",
                    'default' => __("Google Privacy Policy", 'surfalert'),
                    'placeholder' => __("Google Privacy Policy", 'surfalert'),
                    'rules' => Rules::logicalRule([
                        Rules::is('preference_google', true),
                    ]),
                ],
                [
                    'label' => __("URL", 'surfalert'),
                    'name'  => "preference_google_Link_url",
                    'type'  => "text",
                    'placeholder' => __("Google Privacy Policy URL", 'surfalert'),
                    'default' => 'https://business.safety.google/privacy',
                    'rules' => Rules::logicalRule([
                        Rules::is('preference_google', true),
                    ]),
                ],
                [
                    'label' => __("Save My Preferences Button", 'surfalert'),
                    'name'  => "preference_btn",
                    'type'  => "text",
                    'default' => __("Save My Preferences", 'surfalert'),
                    'placeholder' => __("Button text", 'surfalert'),
                ],
                [
                    'label' => __("See more Button", 'surfalert'),
                    'name'  => "preference_more_btn",
                    'type'  => "text",
                    'default' => __("See more", 'surfalert'),
                    'placeholder' => __("Button text", 'surfalert'),
                ],
                [
                    'label' => __("See less Button", 'surfalert'),
                    'name'  => "preference_less_btn",
                    'type'  => "text",
                    'default' => __("See less", 'surfalert'),
                    'placeholder' => __("Button text", 'surfalert'),
                ],
            ]
        ];

        $_fields['cookies_list'] = [
            'name'     => "cookies_list",
            'type'     => "section",
            'priority' => 100,
            'label'    => 'Cookies List',
            'rules'    => Rules::is('type', 'gdpr'),
            'fields'   => [
                [
                    'label' => __("Show Cookie List", 'surfalert'),
                    'name'  => "cookie_list_show_banner",
                    'type'  => "toggle",
                    'default' => true,
                ],
                [
                    'label' => __("Enabled Label", 'surfalert'),
                    'name'  => "cookie_list_active_label",
                    'type'  => "text",
                    'default' => __("Enabled", 'surfalert'),
                    'placeholder' => __("Label text", 'surfalert'),
                ],
                [
                    'label' => __("No Cookies Available Label", 'surfalert'),
                    'name'  => "cookie_list_no_cookies_label",
                    'type'  => "text",
                    'placeholder' => __("Label text", 'surfalert'),
                    'default' => __("No Cookies Available", 'surfalert'),
                ],
            ]
        ];

        return $fields;
    }

    public function add_content_fields( $fields ) {
        $_fields = &$fields['fields'];
        $_fields['gdpr_title'] = [
            'label'    => __('Title', 'surfalert'),
            'name'     => 'gdpr_title',
            'type'     => 'text',
            'priority' => 101,
            'default' => __('We value your privacy', 'surfalert'),       
            'placeholder' => __('Cookie Notice Title', 'surfalert'),       
        ];
        $_fields['gdpr_message'] = [
            'label'    => __('Message', 'surfalert'),
            'name'     => 'gdpr_message',
            'type'     => 'textarea',
            'priority' => 102,
            'default' => __('We use cookies to improve your experience. By continuing to use our site, you agree to our use of cookies and data collection. You can learn more in our Privacy Policy and change your preferences anytime.', 'surfalert'),   
            'placeholder' => __('Message', 'surfalert'),    
        ];
        $_fields['gdpr_accept_btn'] = [
            'label'    => __('Accept All Button', 'surfalert'),
            'name'     => 'gdpr_accept_btn',
            'type'     => 'text',
            'priority' => 103,
            'placeholder' => __('Button Text', 'surfalert'),
            'default' => __('Accept All', 'surfalert'),       
        ];
        $_fields['gdpr_reject_btn'] = [
            'label'    => __('Reject All Button', 'surfalert'),
            'name'     => 'gdpr_reject_btn',
            'type'     => 'text',
            'priority' => 104,
            'placeholder' => __('Button Text', 'surfalert'),
            'default' => __('Reject All', 'surfalert'),       
        ];
        $_fields['gdpr_customize_btn'] = [
            'label'    => __('Customize Button', 'surfalert'),
            'name'     => 'gdpr_customize_btn',
            'type'     => 'text',
            'priority' => 105,
            'placeholder' => __('Button Text', 'surfalert'),
            'default' => __('Customize', 'surfalert'),       
        ];
        $_fields['gdpr_cookies_policy_toggle'] = [
            'label'    => __('Cookies Policy Link', 'surfalert'),
            'name'     => 'gdpr_cookies_policy_toggle',
            'type'     => 'toggle',
            'priority' => 106,
            'default' => true,       
        ];
        $_fields['gdpr_cookies_policy_link_text'] = [
            'label'    => __('Cookies Policy Link Text', 'surfalert'),
            'name'     => 'gdpr_cookies_policy_link_text',
            'type'     => 'text',
            'priority' => 107,
            'placeholder' => __('Link Text', 'surfalert'),
            'default' => __('Cookies Policy', 'surfalert'),
            'rules' => Rules::logicalRule([
                Rules::is('gdpr_cookies_policy_toggle', true),
            ]),      
        ];
        $_fields['gdpr_cookies_policy_link_url'] = [
            'label'    => __('Cookies Policy URL', 'surfalert'),
            'name'     => 'gdpr_cookies_policy_link_url',
            'type'     => 'text',
            'priority' => 108,
            'placeholder' => __('Cookies Policy URL', 'surfalert'),
            'rules' => Rules::logicalRule([
                Rules::is('gdpr_cookies_policy_toggle', true),
            ]),      
        ];
        $_fields['gdpr_custom_logo'] = [
            'label'    => __('Custom Logo', 'surfalert'),
            'name'     => 'gdpr_custom_logo',
            'type'     => 'media',
            'priority' => 109, 
            'is_pro'   => true, 
            'default'  => [
                'url' => 'https://surfalert.com/wp-content/uploads/2025/01/cookie-image.png',
            ],
            'rules' => Rules::logicalRule([
                Rules::is('themes', 'gdpr_theme-banner-light-one', true),
                Rules::is('themes', 'gdpr_theme-light-one', true),
                Rules::is('themes', 'gdpr_theme-light-two', true),
                Rules::is('themes', 'gdpr_theme-banner-dark-one', true),
                Rules::is('themes', 'gdpr_theme-dark-one', true),
                Rules::is('themes', 'gdpr_theme-dark-two', true),
            ]),     
        ];
        return $fields;
    }


}
