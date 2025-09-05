<?php

namespace SurfAlert\ThirdParty;

use SurfAlert\Admin\Settings;
use SurfAlert\Core\Helper;
use SurfAlert\Core\PostType;
use SurfAlert\Core\REST;
use SurfAlert\Extensions\ExtensionFactory;
use SurfAlert\GetInstance;
use WP_Error;
use WP_REST_Server;
use UsabilityDynamics\Settings as UsabilityDynamicsSettings;

/**
 * @method static WPML get_instance($args = null)
 */
class WPML {
    /**
     * Instance of WPML
     *
     * @var WPML
     */
    use GetInstance;

    protected $inclued_entry_key = [
        'name',
        'first_name',
        'last_name',
        // 'link', // link is automatically translated.
        'title',
        'city',
        'state',
        'country',
        'city_country',
    ];

    private $template = [
        'custom_first_param'  => "Custom First Parameter",
        'second_param'        => "Second Param",
        'custom_third_param'  => "Custom Third Param",
        'custom_fourth_param' => "Custom Fourth Parameter",
        'custom_fifth_param'  => "Custom Fifth Parameter",
        'custom_sixth_param'  => "Custom Sixth Parameter",
        'map_fourth_param'    => "Map Fourth Parameter",
        'ga_fourth_param'     => "Google Analytics Fourth Parameter",
        'ga_fifth_param'      => "Google Analytics Fifth Parameter",
        'review_fourth_param' => "Review Fourth Parameter",
    ];

    /**
     * Constructor.
     *
     */
    public function __construct() {
        add_action('wpml_st_loaded', [$this, 'st_loaded'], 10);
        // localize moment even without wpml;
        // can't load moment locale in admin. it cause problem in date picker.
        // add_action('surfalert_admin_scripts', [$this, 'localize_moment'], 10);
    }

    /**
     * This method is reponsible for Admin Menu of
     * SurfAlert
     *
     * @return void
     */
    public function st_loaded() {

        add_action('init', [$this, 'init'], 10);

        add_action('sa_saved_post', [$this, 'register_package'], 10, 3);
        add_action('sa_delete_post', [$this, 'delete_translation'], 10, 2);
        add_filter('sa_get_post', [$this, 'translate_values'], 10);

        add_filter('sa_rest_data', [$this, 'rest_data']);
        add_filter('sa_builder_configs', [$this, 'builder_configs']);
        add_filter('sa_check_location', [$this, 'check_location'], 10, 3);
        add_action( 'wp_ajax_sa-translate', [$this, 'translate'] );

    }

    public function init(){
        // load translated version of the settings.
        Settings::get_instance()->_load();

    }

    public function get_meta($post){
        $meta = [];
        $meta['title'] = ['Title', 'LINE'];
        if($post['source'] == 'press_bar'){
            if(empty($post['elementor_id'])){
                $meta['press_content']          = ['Notification Bar Content', 'VISUAL'];
                $meta['button_text']            = ['Button Text', 'LINE'];
                $meta['button_url']             = ['Button URL', 'LINE'];
                $meta['countdown_expired_text'] = ['Countdown Expired Text', 'LINE'];
                $meta['countdown_text']         = ['Countdown Text', 'LINE'];
                $meta['coupon_text']         = ['Coupon Text', 'LINE'];
            }
        }
        else{
            if(!empty($post['link_type'])){
                $meta['custom_url'] = ['Custom URL', 'LINE'];
            }
            if(!empty($post['template_adv'])){
                $meta['advanced_template'] = ['Advance Template', 'VISUAL'];
            }
            if(($post['source'] == 'edd' || $post['source'] == 'woocommerce') && !empty($post['combine_multiorder'])){
                $meta['combine_multiorder_text'] = ['Combine Multi Order Text', 'LINE'];
            }
            if(($post['type'] == 'conversions') && !empty($post['link_button'])){
                $meta['link_button_text'] = ['Link Button Text', 'LINE'];
            }
        }
        return apply_filters('sa_wpml_translate_field', $meta, $post);
    }

    public function localize_moment($sa_ids = null, $return_url = false){
        return null;
    }

    public function generate_package($post, $sa_id){
        return array(
            'kind'      => 'SurfAlert',
            'name'      => "$sa_id",
            'title'     => isset($post['title']) ? $post['title'] : '', // ($sa_id)
            'edit_link' => PostType::get_instance()->get_edit_link($sa_id),
            'view_link' => PostType::get_instance()->get_edit_link($sa_id),
        );
    }

    public function register_package($post, $data, $sa_id){
        $data = array_merge($post, $data);
        if(empty($data['is_translated'])){
            return;
        }

        $package = $this->generate_package($data, $sa_id);

        $settings = new UsabilityDynamicsSettings(['data' => $post]);


        foreach ($this->get_meta($data) as $key => $param) {
            $_key = isset($param[2]) ? $param[2] : $key;
            if($value = $settings->get($_key)){
                $title = $param[0];
                $type  = $param[1];
                do_action('wpml_register_string', $value, $key, $package, $title, $type);
            }
        }

        if($post['source'] != 'google'){
            unset($this->template['ga_fourth_param']);
            unset($this->template['ga_fifth_param']);
        }
        if(strpos($data['themes'], 'maps_theme') === false){
            unset($this->template['map_fourth_param']);
        }

        if($post['source'] != 'press_bar' && $post['source'] != 'flashing_tab'){
            // @todo when theme template have all the params.
            // $source = $data['source'];
            // $theme = $data['themes'];
            // $ext = ExtensionFactory::get_instance()->get($source);
            // $themes = $ext ? $ext->get_themes() : null;
            // if(!empty($themes[$theme]['template'])){
            // }

            foreach ($this->template as $key => $param) {
                $_key = "notification-template.$key";
                if($value = $settings->get($_key)){
                    do_action('wpml_register_string', $value, $key, $package, $param, 'LINE');
                }
            }
        }

    }

    public function translate_values($post){
        if(empty($_GET['frontend']) && !did_action( "sa_inline" )){
            // checking if request came from frontend.
            return $post;
        }

        $settings = new UsabilityDynamicsSettings(['data' => $post]);

        $package = $this->generate_package($post, $post['sa_id']);

        foreach ($this->get_meta($post) as $key => $param) {
            $_key = isset($param[2]) ? $param[2] : $key;
            if($value = $settings->get($_key)){
                $value = apply_filters( 'wpml_translate_string', $value, $key, $package );
                $settings->set($_key, $value);
            }
        }

        if($post['source'] != 'press_bar'){
            foreach ($this->template as $key => $param) {
                $_key = "notification-template.$key";
                if($value = $settings->get($_key)){
                    $value = apply_filters( 'wpml_translate_string', $value, $key, $package );
                    $settings->set($_key, $value);
                }
            }
        }
        return $settings->get();
    }

    public function delete_translation($sa_id, $post){
        $package = $this->generate_package($post, $sa_id);
        do_action( 'wpml_delete_package', $package['name'], $package['kind'] );
    }

    /**
     * We are only translating when user click translate button.
     *
     * @param [type] $request
     * @return void
     */
    public function translate($request){
        if(!empty($_GET['id'])){
            $sa_id = sanitize_text_field( $_GET['id'] );
            $post = PostType::get_instance()->get_post($sa_id);
            if($post['source'] == 'press_bar' && !empty($post['elementor_id'])){
		        $cookie = new \WPML_Cookie();
				$cookie_data = filter_var( http_build_query( ['type' => 'sa_bar'] ), FILTER_SANITIZE_URL );
				$cookie->set_cookie( 'wp-translation_dashboard_filter', $cookie_data, time() + HOUR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );

                wp_redirect(admin_url("admin.php?page=wpml-translation-management/menu/main.php&sm=dashboard"));
                die;
            }
            else if($post){
                $post['is_translated'] = true;
                PostType::get_instance()->update_post([
                    'data' => $post,
                ], $sa_id);

                $this->register_package($post, [], $sa_id);
                wp_redirect(admin_url("admin.php?page=wpml-string-translation/menu/string-translation.php&context=surfalert-$sa_id"));
                die;
            }
        }
		return new WP_Error();
    }
    public function can_translate( $request ) {
        return current_user_can('wpml_manage_string_translation');
    }

    /**
     * Frontend append lang param.
     *
     * @param [type] $rest
     * @return void
     */
    public function rest_data($rest){
        $my_default_lang = apply_filters('wpml_default_language', NULL );
        $my_current_lang = apply_filters( 'wpml_current_language', NULL );
        if($my_default_lang != $my_current_lang){
            $rest['lang'] = $my_current_lang;
        }
        return $rest;
    }

    /**
     * Backend check if translation is enabled.
     *
     * @param [type] $rest
     * @return void
     */
    public function builder_configs($tabs){
        $tabs['can_translate'] = true;
        return $tabs;
    }

    public function check_location($check_location, $custom_ids, $show_on = []){
        if(!$check_location && $custom_ids){
            global $post;
            if( empty( $custom_ids ) || empty($post) ) {
                return false;
            }
            $custom_ids = explode(',', $custom_ids);
            $custom_ids = array_map('trim', $custom_ids);
            if( is_post_type_archive( 'product' ) ) {
                if( in_array( get_option( 'woocommerce_shop_page_id' ), $custom_ids ) ) {
                    return true;
                }
            }
            return in_array( $post->ID, $custom_ids ) ? true : false;
        }
        return $check_location;
    }
}
