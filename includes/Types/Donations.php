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
use SurfAlert\SurfAlert;

/**
 * Extension Abstract for all Extension.
 * @method static Donations get_instance($args = null)
 */
class Donations extends Types {
    /**
     * Instance of Admin
     *
     * @var Admin
     */
    use GetInstance;

    // donation_themes
    public $priority = 40;
    public $themes = [];
    public $module = ['modules_give'];
    public $default_source    = 'give';
    public $default_theme = 'donation_theme-one';
    public $link_type = 'donation_page';


    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
        $this->id     = 'donation';
    }

    public function init() {
        parent::init();
        $this->title  = __('Donations', 'surfalert');
        $common_fields = array(
            'first_param' => 'tag_name',
            'custom_first_param'  => __('Someone', 'surfalert'),
            'second_param' => __('recently donated for', 'surfalert'),
            'third_param' => 'tag_none',
            'custom_third_param' => __('100', 'surfalert'),
            'fourth_param' => 'tag_title',
            'custom_fourth_param' => __('Anonymous Title', 'surfalert'),
            'fifth_param' => 'tag_time',
            'custom_fifth_param' => __('Some time ago', 'surfalert'),
        );
        $this->themes = [
            'theme-one'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-1.jpg',
                'image_shape' => 'circle',
                'template'  => $common_fields,
            ],
            'theme-two'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-2.jpg',
                'image_shape' => 'circle',
                'template'  => $common_fields,
            ],
            'theme-three' => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-3.jpg',
                'image_shape' => 'square',
                'template'  => $common_fields,
            ],
            'theme-four'  => [
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-4.png',
                'image_shape' => 'circle',
                'template'  => $common_fields,
            ],
            'theme-five' => [
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-5.png',
                'image_shape' => 'circle',
                'template'  => $common_fields,
            ],
            'conv-theme-six' => [
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-6.jpg',
                'image_shape' => 'circle',
            ],
            'maps_theme' => [
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/maps-theme.png',
                'image_shape' => 'square',
                'show_notification_image' => 'maps_image',
            ],
            'conv-theme-seven' => [
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-7.png',
                'image_shape' => 'rounded',
            ],
            'conv-theme-eight' => [
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-8.png',
                'image_shape' => 'circle',
            ],
            'conv-theme-nine' => [
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/donation/donation-theme-9.png',
                'image_shape' => 'square',
            ],
        ];
        $this->res_themes = [
            'res-theme-one'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-1.png',
                '_template' => 'donation_template_new',
                'is_pro'    => true,
            ],
            'res-theme-two'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-2.png',
                '_template' => 'donation_template_new',
                'is_pro'    => true,
            ],
            'res-theme-three' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-3.png',
                '_template' => 'donation_template_new',
                'is_pro'    => true,
            ],
            'res-theme-four'  => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-4.png',
                '_template' => 'donation_template_new',
                'is_pro'    => true,
            ],
            'res-theme-five' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-5.png',
                '_template' => 'donation_template_new',
                'is_pro'    => true,
            ],
            'res-theme-six' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-6.png',
                '_template' => 'donation_template_new',
                'is_pro'    => true,
            ],
            'res-theme-seven' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-7.png',
                '_template' => 'maps_template_new',
                'is_pro'    => true,
            ],
            'res-theme-eight' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-8.png',
                '_template' => 'donation_template_sales_count',
                'is_pro'    => true,
            ],
            'res-theme-nine' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-9.png',
                '_template' => 'donation_template_sales_count',
                'is_pro'    => true,
            ],
            'res-theme-ten' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_donation/donation-res-theme-10.png',
                '_template' => 'donation_template_sales_count',
                'is_pro'    => true,
            ],
        ];
        $this->templates = [
            'donation_template_new' => [
                'first_param' => GlobalFields::get_instance()->common_name_fields(),
                'third_param' => [ // amount_param
                    'tag_amount' => __('Donation Amount', 'surfalert'),
                    'tag_none'   => __('None', 'surfalert'),
                ],
                'fourth_param' => [ // third_param
                    'tag_title'           => __('Donation For Title', 'surfalert'),
                    // 'tag_anonymous_title' => __('Anonymous Title', 'surfalert'),
                ],
                'fifth_param' => [ // fourth_param
                    'tag_time' => __('Definite Time', 'surfalert'),
                    // @todo add more options in pro version https://github.com/WPDevelopers/surfalert-pro/blob/440595540e9d3e26e9e2b674921dede7174b22eb/features/class-nxpro-sales-features.php#L290
                ],
                '_themes' => [
                    'donation_theme-one',
                    'donation_theme-two',
                    'donation_theme-three',
                    'donation_theme-four',
                    'donation_theme-five',
                    'donation_maps_theme',
                ],
            ],
            'donation_template_sales_count' => [
                'first_param' => GlobalFields::get_instance()->common_name_fields(),
                'third_param' => [ // third_param
                    'tag_title'           => __('Donation For Title', 'surfalert'),
                    // 'tag_anonymous_title' => __('Anonymous Title', 'surfalert'),
                ],
                'fourth_param' => [ // fourth_param
                    // @todo add more options in pro version https://github.com/WPDevelopers/surfalert-pro/blob/440595540e9d3e26e9e2b674921dede7174b22eb/features/class-nxpro-sales-features.php#L290
                ],
                '_themes' => [
                    'donation_conv-theme-six',
                    'donation_conv-theme-seven',
                    'donation_conv-theme-eight',
                    'donation_conv-theme-nine',
                ],
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
        add_filter('sa_link_types', [$this, 'link_types']);
    }

    /**
     * Adds option to Link Type field in Content tab.
     *
     * @param array $options
     * @return array
     */
    public function link_types($options) {
        $_options = GlobalFields::get_instance()->normalize_fields([
            'donation_page' => __('Donation Form Page', 'surfalert'),
        ], 'type', $this->id);

        return array_merge($options, $_options);
    }

    public function preview_entry($entry, $settings){
        $entry = array_merge($entry, [
            "title"             => "Fundraising Camp for Health",

        ]);
        return $entry;
    }

}
