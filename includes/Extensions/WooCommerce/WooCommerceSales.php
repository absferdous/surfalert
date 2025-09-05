<?php
/**
 * WooCommerce Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\WooCommerce;

use SurfAlert\Admin\Entries;
use SurfAlert\Core\Helper;
use SurfAlert\Core\PostType;
use SurfAlert\Core\Rules;
use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;
use SurfAlert\Extensions\GlobalFields;

/**
 * WooCommerce Extension Class
 * @method static WooCommerce get_instance($args = null)
 */
class WooCommerceSales extends WooCommerce {
    /**
     * Instance of WooInline
     *
     * @var WooCommerceSales
     */
    protected static $instance = null;
    public $priority        = 5;
    public $id              = 'woocommerce_sales';
    public $img             = '';
    public $doc_link        = 'https://surfalert.com/docs/woocommerce-notification-in-surfalert/';
    public $types           = 'woocommerce_sales';
    public $module          = 'modules_woocommerce';
    public $module_priority = 3;
    public $class           = '\WooCommerce';
    public $default_theme   = 'woocommerce_sales_theme-one';
    public $wpml_included   = [
                                'sales_count', 'donation_count'
                              ];

    /**
     * Get the instance of called class.
     *
     * @return WooCommerce
    */
    public static function get_instance($args = null){
        if ( is_null( static::$instance ) || ! static::$instance instanceof self ) {
            $class = __CLASS__;
            if(strpos($class, "SurfAlert\\") === 0){
                $pro_class = str_replace("SurfAlert\\", "NotificationXPro\\", $class);
                if(class_exists($pro_class)){
                    $class = $pro_class;
                }
            }

            if(!empty($args)){
                static::$instance = new $class($args);
            }
            else{
                static::$instance = new $class;
            }
        }
        return static::$instance;
    }
    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
        // sa_colored_themes
        // $common_fields = [
        //     'first_param'         => 'tag_name',
        //     'custom_first_param'  => __('Someone' , 'surfalert'),
        //     'second_param'        => __('just purchased', 'surfalert'),
        //     'third_param'         => 'tag_product_title',
        //     'custom_third_param'  => __('Anonymous Product', 'surfalert'),
        //     'fourth_param'        => 'tag_time',
        //     'custom_fourth_param' => __( 'Some time ago', 'surfalert' ),
        // ];
        // $this->themes = [
        //     'theme-one'   => [
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-2.jpg',
        //         'image_shape' => 'square',
        //         'template'  => $common_fields,
        //     ],
        //     'theme-two'   => [
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-1.jpg',
        //         'image_shape' => 'square',
        //         'template'  => $common_fields,
        //     ],
        //     'theme-three' => [
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-3.jpg',
        //         'image_shape' => 'square',
        //         'template'  => $common_fields,
        //     ],
        //     'theme-four' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-four.png',
        //         'image_shape' => 'circle',
        //         'template'  => $common_fields,
        //     ),
        //     'theme-five' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-five.png',
        //         'image_shape' => 'circle',
        //         'template'  => $common_fields,
        //     ),
        //     // @todo pro map theme
        //     'conv-theme-six' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-6.jpg',
        //         'image_shape' => 'circle',
        //     ),
        //     // @todo pro map theme
        //     'maps_theme' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/maps-theme.png',
        //         'image_shape' => 'square',
        //         'show_notification_image' => 'maps_image',
        //     ),
        //     'conv-theme-ten' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-4.png',
        //         'image_shape' => 'rounded',
        //         'defaults'     => [
        //             'link_button'   => true,
        //             'link_button_text'   => __('Buy Now'),
        //         ],
        //         'template'  => $common_fields,
        //     ),
        //     'conv-theme-eleven' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-conv-theme-5.png',
        //         'image_shape' => 'rounded',
        //         'defaults'     => [
        //             'link_button'   => true,
        //             'link_button_text'   => __('Buy Now'),
        //         ],
        //         'template'  => $common_fields,
        //     ),
        //     'conv-theme-seven' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-7.png',
        //         'image_shape' => 'rounded',
        //     ),
        //     'conv-theme-eight' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-8.png',
        //         'image_shape' => 'circle',

        //     ),
        //     'conv-theme-nine' => array(
        //         'is_pro' => true,
        //         'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-conv-theme-9.png',
        //         'image_shape' => 'rounded',
        //     ),
        // ];
        // $this->templates = [
        //     'woo_template_new' => [
        //         'first_param' => GlobalFields::get_instance()->common_name_fields(),
        //         'third_param' => [
        //             'tag_product_title' => __('Product Title', 'surfalert'),
        //         ],
        //         'fourth_param' => [
        //             'tag_time' => __('Definite Time', 'surfalert'),
        //         ],
        //         '_themes' => [
        //             'woocommerce_sales_theme-one',
        //             'woocommerce_sales_theme-two',
        //             'woocommerce_sales_theme-three',
        //             'woocommerce_sales_theme-four',
        //             'woocommerce_sales_theme-five',
        //             'woocommerce_sales_conv-theme-ten',
        //             'woocommerce_sales_conv-theme-eleven',
        //         ]
        //     ],
        //     'woo_sales_template_sales_count' => [
        //         'first_param' => GlobalFields::get_instance()->common_name_fields(),
        //         'third_param' => [
        //             'tag_product_title' => __('Product Title', 'surfalert'),
        //         ],
        //         'fourth_param' => [
        //             // 'tag_time' => __('Definite Time', 'surfalert'),
        //         ],
        //         '_themes' => [
        //             'woocommerce_sales_conv-theme-six',
        //             'woocommerce_sales_conv-theme-seven',
        //             'woocommerce_sales_conv-theme-eight',
        //             'woocommerce_sales_conv-theme-nine',
        //         ]
        //     ],
        // ];
    }

    public function init_extension()
    {
        $this->title = __('Sales Notification', 'surfalert');
        $this->module_title = __('Sales Notification', 'surfalert');
    }

    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">WooCommerce installed & activated</a> to use this campaign. For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a href="%3$s" target="_blank">Watch video tutorial</a> to learn quickly</p>
		<p>⭐ SurfAlert Integration with WooCommerce</p>
		<p><strong>Recommended Blog:</strong></p>
		<p>🔥 Why SurfAlert is The <a target="_blank" href="%4$s">Best FOMO and Social Proof Plugin</a> for WooCommerce?</p>
		<p>🚀 How to <a target="_blank" href="%5$s">boost WooCommerce Sales</a> Using SurfAlert</p>', 'surfalert'),
        'https://wordpress.org/plugins/woocommerce/',
        'https://surfalert.com/docs/configure-woocommerce-sales-alert/',
        'https://www.youtube.com/watch?v=dVthd36hJ-E&t=1s',
        'https://surfalert.com/integrations/woocommerce/',
        'https://surfalert.com/blog/best-fomo-and-social-proof-plugin-for-woocommerce/'
        );
    }

}
