<?php

namespace SurfAlert\Core\Rest;

use SurfAlert\Core\PostType;
use SurfAlert\Core\REST;
use SurfAlert\Extensions\ExtensionFactory;
use SurfAlert\Extensions\GlobalFields;
use SurfAlert\GetInstance;
use SurfAlert\SurfAlert;
use WP_REST_Controller;
use WP_REST_Response;
use WP_REST_Server;
use WP_Error;

/**
 * @method static Integration get_instance($args = null)
 */
class Integration {
    /**
     * Instance of SurfAlert
     *
     * @var SurfAlert
     */
    use GetInstance;

    public $namespace;
    public $rest_base;

    /**
     * Constructor.
     *
     * @since 4.7.0
     *
     * @param string $post_type Post type.
     */
    public function __construct() {
        $this->namespace = 'surfalert/v1';
        $this->rest_base = 'notification';
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes() {
        // Settings Integration
        register_rest_route( $this->namespace, '/api-connect', array(
            'methods'   => WP_REST_Server::EDITABLE,
            'callback'  => array( $this, 'api_connect' ),
            'permission_callback' => array($this, 'settings_permission'),
        ));

        // calls from integration provider.
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            array(
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array($this, 'get_response'),
                    'permission_callback' => '__return_true',
                    'args' => array(
                        'id' => array(
                            'required' => true,
                            'description' => __('Unique identifier for the object.', 'surfalert'),
                            'type'        => 'integer',
                        ),
                        'api_key' => array(
                            'required' => true,
                            'description' => __('Unique identifier for the site.', 'surfalert'),
                            'type'        => 'string',
                        ),
                    ),
                ),
                array(
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => array($this, 'save_response'),
                    'permission_callback' => '__return_true',
                    'args' => array(
                        'id' => array(
                            'required' => true,
                            'description' => __('Unique identifier for the object.', 'surfalert'),
                            'type'        => 'integer',
                        ),
                        'api_key' => array(
                            'required' => true,
                            'description' => __('Unique identifier for the site.', 'surfalert'),
                            'type'        => 'string',
                        ),
                    ),
                ),
            )
        );
        // OLD Fallback for Zapier
        register_rest_route(
            "surfalert",
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            array(
                array(
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => array($this, 'get_response'),
                    'permission_callback' => '__return_true',
                    'args' => array(
                        'id' => array(
                            'required' => true,
                            'description' => __('Unique identifier for the object.', 'surfalert'),
                            'type'        => 'integer',
                        ),
                        'api_key' => array(
                            'required' => true,
                            'description' => __('Unique identifier for the site.', 'surfalert'),
                            'type'        => 'string',
                        ),
                    ),
                ),
                array(
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => array($this, 'save_response'),
                    'permission_callback' => '__return_true',
                    'args' => array(
                        'id' => array(
                            'required' => true,
                            'description' => __('Unique identifier for the object.', 'surfalert'),
                            'type'        => 'integer',
                        ),
                        'api_key' => array(
                            'required' => true,
                            'description' => __('Unique identifier for the site.', 'surfalert'),
                            'type'        => 'string',
                        ),
                    ),
                ),
            )
        );
    }

    public function get_response( \WP_REST_Request $request ){
        $id        = $request['id'];
		$api_key   = $request['api_key'];
        $error     = [];

		if( $api_key === md5( home_url( '', 'http' ) ) || $api_key === md5( home_url( '', 'https' ) ) ) {
            $surfalert = PostType::get_instance()->get_post( $id );
            if( $surfalert ) {
                return wp_send_json( true );
            }
            $error['message'] = __( 'There is no notification created with this id:' . $id, 'surfalert' );
            return wp_send_json_error( $error, 401 );
		} else {
			$error['message'] = __( 'Error: API Key Invalid!', 'surfalert' );
			return wp_send_json_error( $error, 401 );
		}
    }

    /**
     * Undocumented function
     *
     * @param \WP_REST_Request $request
     * @return void
     */
    public function save_response( \WP_REST_Request $request ){
        $response_data = array(
            'data'      => '',
            'error'     => false
        );

        if ( ! isset( $request['api_key'] ) ) {
            $response_data['error'] = __('Error: You should provide an API key.', 'surfalert');
        } else {
            if( md5( home_url( '', 'http' ) ) != $request['api_key'] && md5( home_url( '', 'https' ) ) != $request['api_key'] ) {
                $response_data['error'] = __('Error: Invalid API key.', 'surfalert');
            }
        }

        if ( ! $response_data['error'] ) {
            $response_data['data'] = $request->get_params();
            if ( isset( $response_data['data']['api_key'] ) ) {
                unset( $response_data['data']['api_key'] );
            }
            if (isset($response_data['data']['id'])){
                $post = PostType::get_instance()->get_post($response_data['data']['id']);
                if($post['source']){
                    do_action( "sa_api_response_success_{$post['source']}", $response_data['data'] );
                }
            }
            do_action( 'sa_api_response_success', $response_data['data'] );
        }

        return apply_filters( 'sa_api_response', $response_data );
    }

    /**
     * Undocumented function
     *
     * @param \WP_REST_Request $request
     * @return
     */
    public function api_connect( \WP_REST_Request $request ){
        $params = $request->get_params();
        $source = !empty($params['source']) ? $params['source'] : '';
        /**
         * @var Extension
         */
        $ext = ExtensionFactory::get_instance()->get($source);
        if($ext && method_exists($ext, 'connect')){
            return $ext->connect($params);
        }
        else{
            $result = apply_filters("sa_api_connect_$source", null, $params);
            if($result){
                return $result;
            }
        }
        return REST::get_instance()->error();
    }

    public function settings_permission( $request ) {
        return current_user_can('edit_surfalert_settings');
    }
}
