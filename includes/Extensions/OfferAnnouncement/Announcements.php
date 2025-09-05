<?php
/**
 * Announcements Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\OfferAnnouncement;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;
use SurfAlert\Extensions\ExtensionFactory;
use SurfAlert\Extensions\GlobalFields;
use SurfAlert\Types\Conversions;

/**
 * Announcements Extension
 * @method static Announcements get_instance($args = null)
 */
class Announcements extends Extension {
    /**
     * Instance of Announcements
     *
     * @var Announcements
     */
    use GetInstance;

    public $priority        = 10;
    public $id              = 'announcements';
    // public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/custom.png';
    // public $doc_link        = 'https://surfalert.com/docs/custom-notification';
    public $types           = 'offer_announcement';
    public $module          = 'modules_announcements';
    public $module_priority = 18;
    public $is_pro          = true;
    public $link_type       = 'announcements_link';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('Discount Announcement', 'surfalert');
        $this->module_title = __('Discount Announcement', 'surfalert');
        $this->themes = [
            'theme-1'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/announcements/theme-1.png',
                'image_shape' => 'rounded',
                'template' => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Flash Sale: Limited Time Offer!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
                    // 'fifth_param'         => 'tag_offer_discount',
                    // 'custom_fifth_param'  => __( 'Some time ago', 'surfalert' ),
                ],
                'defaults' => [
                    // 'announcement_link_button'      => false,
                    'link'                          => '#',
                    'offer_title'                   => __( 'Flash Sale: Limited Time Offer!', 'surfalert' ),
                    'offer_description'             => __( 'Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert' ),
                    'announcement_link_button_text' => __( 'Grab Now', 'surfalert' ),
                ],
            ],
            'theme-2'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/announcements/theme-2.png',
                'template' => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Flash Sale: Limited Time Offer!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
                    // 'fifth_param'         => 'tag_offer_discount',
                    // 'custom_fifth_param'  => __( '25% OFF', 'surfalert' ),
                ],
                'defaults' => [
                    // 'announcement_link_button'      => false,
                    'link'                          => '#',
                    'offer_title'                   => __( 'Flash Sale: Limited Time Offer!', 'surfalert' ),
                    'offer_description'             => __( 'Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert' ),
                    'announcement_link_button_text' => __( 'Grab Now', 'surfalert' ),
                ],
                'image_shape' => 'circle',
            ],
            'theme-12'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/announcements/theme-12.png',
                'template' => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Flash Sale: Limited Time Offer!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
                    // 'fifth_param'         => 'tag_offer_discount',
                    // 'custom_fifth_param'  => __( '25% OFF', 'surfalert' ),
                ],
                'defaults' => [
                    // 'announcement_link_button'      => true,
                    'announcement_link_button_text' => __( 'Buy Now', 'surfalert' ),
                    'link'                          => '#',
                    'offer_title'                   => __( 'Flash Sale: Limited Time Offer!', 'surfalert' ),
                    'link_button'                   => true,
                ],
                'image_shape' => 'rounded',
            ],
            // 'theme-13'   => [
            //     'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/announcements/theme-13.png',
            //     'template' => [
            //         'first_param'         => 'tag_offer_title',
            //         'custom_first_param'  => __('How Does It Works' , 'surfalert'),
            //     ],
            //     'defaults' => [
            //         // 'announcement_link_button'      => false,
            //         'announcement_link_button_text' => __( 'Watch Now', 'surfalert' ),
            //         'offer_title'                   => __( 'How Does It Works', 'surfalert' ),
            //         'link'                          => '#',
            //     ],
            // ],
            'theme-14'   => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/announcements/theme-14.png',
                'image_shape' => 'circle',
                'template'    => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Hi There!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
                      // 'fifth_param'         => 'tag_offer_discount',
                      // 'custom_fifth_param'  => __( 'Some time ago', 'surfalert' ),
                ],
                'defaults' => [
                      // 'announcement_link_button'      => false,
                    'announcement_link_button_text' => __( 'Get It Now', 'surfalert' ),
                    'offer_title'                   => __( 'Hi There!', 'surfalert' ),
                    'link'                          => '#',
                ],
            ],
            'theme-15'   => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/announcements/theme-15.png',
                'template'    => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Hi There!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO', 'surfalert'),
                ],
                'defaults' => [
                    // 'announcement_link_button'      => false,
                    'announcement_link_button_text' => __( 'Book Now', 'surfalert' ),
                    'offer_title'                   => __( 'Hi There!', 'surfalert' ),
                    'offer_description'             => __( 'Enjoy flat 50% Off on SurfAlert PRO', 'surfalert' ),
                    'link'                          => '#',
                ],
            ],
        ];
        $this->res_themes = [
            'res-theme-one'   => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_announcements/announcements-res-theme-1.png',
                'image_shape' => 'rounded',
                'template'    => [
                    'first_param'        => 'tag_offer_title',
                    'custom_first_param' => __('Flash Sale:' , 'surfalert'),
                    'third_param'        => 'tag_offer_description',
                    'fourth_param'       => 'tag_time',
                ],
                'is_pro' => true,
            ],
            'res-theme-two'   => [
                'source'   => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_announcements/announcements-res-theme-2.png',
                'template' => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Flash Sale: Limited Time Offer!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
                      // 'fifth_param'         => 'tag_offer_discount',
                      // 'custom_fifth_param'  => __( '25% OFF', 'surfalert' ),
                ],
                'is_pro' => true,
            ],
            'res-theme-three'   => [
                'source'   => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_announcements/announcements-res-theme-3.png',
                'template' => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Flash Sale: Limited Time Offer!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
                      // 'fifth_param'         => 'tag_offer_discount',
                      // 'custom_fifth_param'  => __( '25% OFF', 'surfalert' ),
                ],
                'is_pro' => true,
            ],
            'res-theme-four'   => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_announcements/announcements-res-theme-4.png',
                'image_shape' => 'circle',
                'template'    => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Hi There!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO Valid till this week', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
                ],
                'is_pro'    => true,
            ],
            'res-theme-five'   => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_announcements/announcements-res-theme-5.png',
                'template'    => [
                    'first_param'         => 'tag_offer_title',
                    'custom_first_param'  => __('Hi There!' , 'surfalert'),
                    'third_param'         => 'tag_offer_description',
                    'custom_third_param'  => __('Enjoy flat 50% Off on SurfAlert PRO', 'surfalert'),
                ],
                'is_pro'    => true,
            ],
        ];

        $this->templates = [
            'announcements_template_new' => [
                'first_param' => [
                    'tag_offer_title' => __('Offer Title', 'surfalert'),
                ],
                'third_param' => [
                    'tag_offer_description' => __('Offer Description', 'surfalert'),
                    // 'tag_anonymous_title' => __('Anonymous Title' , 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_time'     => __('Definite Time', 'surfalert'),
                    'tag_sometime' => __('Some time ago', 'surfalert'),
                ],
                'fifth_param' => [
                    'tag_offer_discount' => __('Discount', 'surfalert'),
                    'tag_offer_image'    => __('Image', 'surfalert'),
                ],
                '_themes' => [
                    "{$this->id}_theme-1",
                    "{$this->id}_theme-2",
                    "{$this->id}_theme-12",
                    "{$this->id}_theme-14",
                    "{$this->id}_theme-15",
                ],
            ],
        ];
    }

   

    /**
     * Get data for CustomNotification Extension.
     *
     * @param array $args Settings arguments.
     * @return array
     */
    public function get_data( $args = array() ){
        return 'Hello From Custom Notification';
    }

    public function doc(){
        return sprintf(__('<p>You can showcase the discount alert popup on your WordPress website to make visitors take purchasing action immediately. For further assistance, check out our step-by-step <a target="_blank" href="%1$s">documentation</a>.</p>
		<p><strong>Recommended Blog:</strong></p>
		<p>🔥Introducing Discount Alert By SurfAlert <a target="_blank" href="%2$s">Guide To Notify Customers About On-Sale Products</a> </p>', 'surfalert'),
        'https://surfalert.com/docs/configure-discount-alert/',
        'https://surfalert.com/discount-alerts/'
        );
    }
}
