<?php
/**
 * Extension Abstract
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Types;

use SurfAlert\Core\Rules;
use SurfAlert\Types\Traits\Conversions;
use SurfAlert\Types\Traits\Reviews;
use SurfAlert\Extensions\GlobalFields;
use SurfAlert\GetInstance;
use SurfAlert\SurfAlert;

/**
 * Extension Abstract for all Extension.
 * @method static WooCommerce get_instance($args = null)
 */
class WooCommerceSales extends Types {
    /**
     * Instance of Admin
     *
     * @var Admin
     */
	use GetInstance;
    use Reviews;
    use Conversions;

    // colored_themes
    public $priority = 5;
    public $themes = [];
    public $res_themes = [];
    public $module = [
        'modules_woocommerce',
        'modules_woocommerce_sales_reviews',
        'modules_woocommerce_sales_inline',
    ];
    
    public $map_dependency = [];

    public $default_source    = 'woocommerce_sales';
    // public $default_theme = 'woocommerce_theme-one';
    public $link_type = 'product_page';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
        $this->id = 'woocommerce_sales';
    }

    public function init() {
        parent::init();
        $this->title = __('WooCommerce', 'surfalert');

        $is_pro = ! SurfAlert::is_pro();
        // sa_colored_themes
        $common_fields = [
            'first_param'         => 'tag_name',
            'custom_first_param'  => __('Someone' , 'surfalert'),
            'second_param'        => __('just purchased', 'surfalert'),
            'third_param'         => 'tag_product_title',
            'custom_third_param'  => __('Anonymous Product', 'surfalert'),
            'fourth_param'        => 'tag_time',
            'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
        ];
        $this->themes = [
            'theme-one'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-2.jpg',
                'image_shape' => 'square',
                'template'  => $common_fields,
            ],
            'theme-two'   => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-1.jpg',
                'image_shape' => 'square',
                'template'  => $common_fields,
            ],
            'theme-three' => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-3.jpg',
                'image_shape' => 'square',
                'template'  => $common_fields,
            ],
            'theme-five' => array(
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-five.png',
                'image_shape' => 'circle',
                'template'  => $common_fields,
            ),
            'theme-four' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-four.png',
                'image_shape' => 'circle',
                'template'  => $common_fields,
            ),
            // @todo pro map theme
            'conv-theme-six' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-6.jpg',
                'image_shape' => 'circle',
            ),
            // @todo pro map theme
            'maps_theme' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/maps-theme.png',
                'image_shape' => 'square',
                'show_notification_image' => 'maps_image',
            ),
            'conv-theme-ten' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-4.png',
                'image_shape' => 'rounded',
                'defaults'     => [
                    'link_button'   => true,
                ],
                'template'  => $common_fields,
            ),
            'conv-theme-eleven' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-5.png',
                'image_shape' => 'rounded',
                'defaults'     => [
                    'link_button'   => true,
                ],
                'template'  => $common_fields,
            ),
            'conv-theme-seven' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-7.png',
                'image_shape' => 'rounded',
            ),
            'conv-theme-eight' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-8.png',
                'image_shape' => 'circle',

            ),
            'conv-theme-nine' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-9.png',
                'image_shape' => 'rounded',
            ),
           
        ];
        $this->res_themes = [
            'res-theme-one'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-1.png',
                '_template' => 'woo_template_new',
                'is_pro'    => true,
            ],
            'res-theme-two'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-2.png',
                '_template' => 'woo_template_new',
                'is_pro'    => true,
            ],
            'res-theme-three'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-3.png',
                '_template' => 'woo_template_new',
                'is_pro'    => true,
            ],
            'res-theme-four'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-4.png',
                '_template' => 'woo_template_new',
                'is_pro'    => true,
            ],
            'res-theme-five'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-5.png',
                '_template' => 'maps_template_new',
                'is_pro'    => true,
            ],
            'res-theme-six'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-6.png',
                '_template' => 'maps_template_new',
                'is_pro'    => true,
            ],
            'res-theme-seven'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-7.png',
                '_template' => 'woo_template_new',
                'is_pro'    => true,
            ],
            'res-theme-eight'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-8.png',
                '_template' => 'woo_template_new',
                'is_pro'    => true,
            ],
            'res-theme-nine'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-9.png',
                '_template' => 'woo_template_sales_count',
                'is_pro'    => true,
            ],
            'res-theme-ten'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-10.png',
                '_template' => 'woo_template_sales_count',
                'is_pro'    => true,
            ],
            'res-theme-eleven'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_conv/sa-conv-res-theme-11.png',
                '_template' => 'woo_template_sales_count',
                'is_pro'    => true,
            ],
        ];
        $this->templates = [
            'woo_template_new' => [
                'first_param' => GlobalFields::get_instance()->common_name_fields(),
                'third_param' => [
                    'tag_product_title' => __('Product Title', 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_time' => __('Definite Time', 'surfalert'),
                ],
                '_themes' => [
                    'woocommerce_sales_theme-one',
                    'woocommerce_sales_theme-two',
                    'woocommerce_sales_theme-three',
                    'woocommerce_sales_theme-four',
                    'woocommerce_sales_theme-five',
                    'woocommerce_sales_conv-theme-ten',
                    'woocommerce_sales_conv-theme-eleven',
                ]
            ],
            'woo_template_sales_count' => [
                'first_param' => GlobalFields::get_instance()->common_name_fields(),
                'third_param' => [
                    'tag_product_title' => __('Product Title', 'surfalert'),
                ],
                'fourth_param' => [
                    // 'tag_time' => __('Definite Time', 'surfalert'),
                ],
                '_themes' => [
                    'woocommerce_sales_conv-theme-six',
                    'woocommerce_sales_conv-theme-seven',
                    'woocommerce_sales_conv-theme-eight',
                    'woocommerce_sales_conv-theme-nine',
                ]
            ],
        ];
        add_filter("sa_filtered_entry_{$this->id}", array($this, 'conversion_data'), 11, 2);
    }
    
    /**
     * Hooked to sa_before_metabox_load action.
     *
     * @return void
     */
    public function init_fields() {
        parent::init_fields();
        add_filter('sa_notification_template', [$this, 'review_templates'], 7);
        add_filter('sa_content_trim_length_dependency', [$this, 'content_trim_length_dependency']);
    }

}
