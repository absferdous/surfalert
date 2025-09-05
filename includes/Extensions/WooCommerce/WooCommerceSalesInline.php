<?php
  /**
 * WooCommerce Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\WooCommerce;

  /**
 * WooCommerce Extension Class
 * @method static WooCommerce get_instance($args = null)
 */
class WooCommerceSalesInline extends WooInline {

    /**
     * Instance of WooInline
     *
     * @var WooInline
    */
    protected static $instance = null;
    public    $priority        = 15;
    public    $id              = 'woocommerce_sales_inline';
    public    $img             = '';
    public    $doc_link        = 'https://surfalert.com/docs/woocommerce-growth-alerts/';
    public    $types           = 'woocommerce_sales';
    public    $module          = 'modules_woocommerce';
    public    $module_priority = 3;
    public    $class           = '\WooCommerce';
    public    $is_pro          = true;

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
    }

    public function init_extension()
    {
        $this->title        = __('Growth Alert', 'surfalert');
        $this->module_title = __('Growth Alert', 'surfalert');
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
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/growth-alert/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>Highlight your sales, low stock updates with inline growth alert to boost sales</span>
                <iframe id="email_subscription_video" type="text/html" allowfullscreen width="450" height="235"
                src="https://www.youtube.com/embed/vXMtBPvizDw">
                </iframe>
            ', 'surfalert')
        ];
    }

    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">WooCommerce installed & activated</a> to use this campaign. For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a href="%3$s" target="_blank">Watch video tutorial</a> to learn quickly</p>
		<p>⭐ SurfAlert Integration with WooCommerce</p>
		<p><strong>Recommended Blog:</strong></p>
		<p>🔥 Why SurfAlert is The <a target="_blank" href="%4$s">Best FOMO and Social Proof Plugin</a> for WooCommerce?</p>
		<p>🚀 How to <a target="_blank" href="%5$s">boost WooCommerce Sales</a> Using SurfAlert</p>', 'surfalert'),
        'https://wordpress.org/plugins/woocommerce/',
        'https://surfalert.com/docs/woocommerce-growth-alerts/',
        'https://www.youtube.com/watch?v=dVthd36hJ-E&t=1s',
        'https://surfalert.com/integrations/woocommerce/',
        'https://surfalert.com/blog/best-fomo-and-social-proof-plugin-for-woocommerce/'
        );
    }

}
