<?php
/**
 * WooCommerce Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\WooCommerce;

use SurfAlert\Core\PostType;
use SurfAlert\Core\Rules;
use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;
use SurfAlert\Extensions\GlobalFields;

/**
 * WooCommerce Extension Class
 */
class WooInline extends WooCommerce {
    /**
     * Instance of WooInline
     *
     * @var WooInline
     */
    protected static $instance = null;
    public $priority        = 5;
    public $id              = 'woo_inline';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/woocommerce.png';
    public $doc_link        = 'https://surfalert.com/docs/woocommerce-sales-notifications/';
    public $types           = 'inline';
    public $module          = 'modules_woocommerce';
    public $module_priority = 3;
    public $class           = '\WooCommerce';
    public $is_pro          = true;

    /**
     * Get the instance of called class.
     *
     * @return WooInline
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
        add_filter( 'sa_show_on_exclude', array( $this, 'show_on_exclude' ), 10, 4 );
    }

    public function init_extension()
    {
        
        $this->themes = [
            'conv-theme-seven' => array(
                'is_pro'      => true,
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/woo-inline.jpg',
                'image_shape' => 'rounded',
                'inline_location' => [ 'woocommerce_before_add_to_cart_form' ],
                'template'    => [
                    'first_param'         => 'tag_sales_count',
                    'custom_first_param'  => __( '99', 'surfalert' ),
                    'second_param'        => __( 'people purchased', 'surfalert' ),
                    'third_param'         => 'tag_product_title',
                    'custom_third_param'  => ' ',
                    'fourth_param'        => 'tag_7days',
                    'custom_fourth_param' => __( 'in last {{day:7}}', 'surfalert' ),
                ],
            ),
            'stock-theme-one' => array(
                'is_pro'      => true,
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/woo-inline-2.jpg',
                'image_shape' => 'rounded',
                'inline_location' => [ 'woocommerce_before_add_to_cart_form' ],
                'template'    => [
                    // 'first_param'         => 'tag_sales_count',
                    // 'custom_first_param'  => __( 'Someone', 'surfalert' ),
                    'second_param'        => __( 'Only', 'surfalert' ),
                    'third_param'         => 'tag_stock_count',
                    'custom_third_param'  => 10,
                    'fourth_param'        => 'tag_left_in_stock',
                    'custom_fourth_param' => __( 'left in stock', 'surfalert' ),
                    'fifth_param'         => 'tag_order_soon',
                    'custom_fifth_param'  => __( '- order soon.', 'surfalert' ),
                ],
            ),
            'stock-theme-two' => array(
                'is_pro'      => true,
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/woo-inline-3.jpg',
                'image_shape' => 'rounded',
                'inline_location' => [ 'woocommerce_after_cart_item_name' ],
                'template'    => [
                    // 'first_param'         => 'tag_sales_count',
                    // 'custom_first_param'  => __( 'Someone', 'surfalert' ),
                    'second_param'        => __( 'In high demand - only', 'surfalert' ),
                    'third_param'         => 'tag_stock_count',
                    'custom_third_param'  => 10,
                    'fourth_param'        => 'tag_left',
                    'custom_fourth_param' => __( 'left', 'surfalert' ),
                    'fifth_param'         => 'tag_on_our_site',
                    'custom_fifth_param'  => __( 'on our site!', 'surfalert' ),
                ],
            ),
        ];
        $this->templates = [
            'woo_template_sales_count' => [
                'first_param'  => [
                    'tag_sales_count' => __( 'Sales Count', 'surfalert' ),
                ],
                'third_param'  => [
                    'tag_product_title' => __( 'Product Title', 'surfalert' ),
                ],
                'fourth_param' => [
                    'tag_1day'   => __( 'In last 1 day', 'surfalert' ),
                    'tag_7days'  => __( 'In last 7 days', 'surfalert' ),
                    'tag_30days' => __( 'In last 30 days', 'surfalert' ),
                ],
                '_themes'      => [
                    "{$this->id}_conv-theme-seven",
                ],
            ],
            'inline_stock_template'    => [
                'third_param'  => [
                    'tag_stock_count' => __( 'Stock Count', 'surfalert' ),
                ],
                'fourth_param' => [
                    'tag_left_in_stock' => __( 'left in stock', 'surfalert' ),
                    'tag_left' => __( 'left', 'surfalert' ),
                ],
                'fifth_param' => [
                    'tag_order_soon' => __( 'order soon.', 'surfalert' ),
                    'tag_on_our_site' => __( 'on our site!', 'surfalert' ),
                ],
                '_themes'      => [
                    "{$this->id}_stock-theme-one",
                    "{$this->id}_stock-theme-two",
                ],
            ],
        ];
    }

    /**
     * @todo Something
     *
     * @param [type] $exclude
     * @param [type] $settings
     * @return void
     */
    public function show_on_exclude( $exclude, $settings ) {
        if ( $settings['source'] === $this->id ) {
            $woo_location = $settings['inline_location'];
            $hooks        = ['woocommerce_before_add_to_cart_form', 'woocommerce_after_shop_loop_item_title', 'woocommerce_after_shop_loop_item', 'woocommerce_after_cart_item_name'];
            $diff         = array_diff( $hooks, $woo_location );
            if ( count( $diff ) <= count( $hooks ) ) {
                return true;
            }
        }
        return $exclude;
    }

    public function content_fields($fields){
        return $fields;
    }

}
