<?php

namespace SurfAlert\Core\Rest;

use SurfAlert\Admin\Admin;
use SurfAlert\Core\Analytics;
use SurfAlert\Core\PostType;
use SurfAlert\GetInstance;
use WP_REST_Server;

/**
 * @method static BulkAction get_instance($args = null)
 */
class BulkAction {
    /**
     * Instance of BulkAction
     *
     * @var BulkAction
     */
    use GetInstance;
    public $namespace;
    public $rest_base;
    /**
     * Post type.
     *
     * @since 4.7.0
     * @var string
     */
    protected $post_type;

    /**
     * Constructor.
     *
     * @since 4.7.0
     *
     * @param string $post_type Post type.
     */
    public function __construct() {
        $this->namespace = 'surfalert/v1';
        $this->rest_base = 'bulk-action';
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes() {
        register_rest_route($this->namespace, "/{$this->rest_base}/delete",
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'delete' ),
                'permission_callback' => [ $this, 'edit_permission' ],
                'args'                => array(
                    'ids' => array(
                        'description' => __( 'Array of sa_id.', 'surfalert' ),
                        'type'        => 'array',
                    ),
                ),
            )
        );
        register_rest_route($this->namespace, "/{$this->rest_base}/regenerate",
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'regenerate' ),
                'permission_callback' => [ $this, 'read_permission' ],
                'args'                => array(
                    'ids' => array(
                        'description' => __( 'Array of sa_id.', 'surfalert' ),
                        'type'        => 'array',
                    ),
                ),
            )
        );
        register_rest_route($this->namespace, "/{$this->rest_base}/enable",
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'enable' ),
                'permission_callback' => [ $this, 'edit_permission' ],
                'args'                => array(
                    'ids' => array(
                        'description' => __( 'Array of sa_id.', 'surfalert' ),
                        'type'        => 'array',
                    ),
                ),
            )
        );
        register_rest_route($this->namespace, "/{$this->rest_base}/disable",
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'disable' ),
                'permission_callback' => [ $this, 'edit_permission' ],
                'args'                => array(
                    'ids' => array(
                        'description' => __( 'Array of sa_id.', 'surfalert' ),
                        'type'        => 'array',
                    ),
                ),
            )
        );
        register_rest_route($this->namespace, "/{$this->rest_base}/reset",
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'reset' ),
                'permission_callback' => [ $this, 'edit_permission' ],
                'args'                => array(
                    'ids' => array(
                        'description' => __( 'Array of sa_id.', 'surfalert' ),
                        'type'        => 'array',
                    ),
                ),
            )
        );
    }

    public function read_permission( $request ) {
        return current_user_can( 'read_surfalert' );
    }
    public function edit_permission( $request ) {
        return current_user_can( 'edit_surfalert' );
    }

    public function delete( $request ) {
        $count  = [];
        $params = $request->get_params();
        if ( ! empty( $params['ids'] ) && is_array( $params['ids'] ) ) {
            foreach ( $params['ids'] as $key => $sa_id ) {
                $count[ $sa_id ] = PostType::get_instance()->delete_post( $sa_id );
            }
        }
        return [
            'success' => true,
            'count'   => $count,
        ];
    }

    public function regenerate( $request ) {
        $count  = 0;
        $params = $request->get_params();
        if ( ! empty( $params['ids'] ) && is_array( $params['ids'] ) ) {
            foreach ( $params['ids'] as $key => $sa_id ) {
                $count += Admin::get_instance()->regenerate_notifications( [ 'sa_id' => $sa_id ] );
            }
        }
        return [
            'success' => true,
            'count'   => $count,
        ];
    }

    public function enable( $request ) {
        $count  = [];
        $params = $request->get_params();
        if ( ! empty( $params['ids'] ) && is_array( $params['ids'] ) ) {
            $ids   = array_map( 'absint', $params['ids'] );
            $posts = PostType::get_instance()->get_posts_by_ids( $ids, null, 'sa_id, source, type' );
            if ( is_array( $posts ) ) {
                foreach ( $posts as $key => $post ) {
                    $count[ $post['sa_id'] ] = PostType::get_instance()->update_status([
                        'sa_id'   => $post['sa_id'],
                        'source'  => $post['source'],
                        'enabled' => true,
                    ]);
                }
            }
        }
        return [
            'success' => true,
            'count'   => $count,
        ];
    }

    public function disable( $request ) {
        $count  = [];
        $params = $request->get_params();
        if ( ! empty( $params['ids'] ) && is_array( $params['ids'] ) ) {
            $ids   = array_map( 'absint', $params['ids'] );
            $posts = PostType::get_instance()->get_posts_by_ids( $ids, null, 'sa_id, source, type' );
            if ( is_array( $posts ) ) {
                foreach ( $posts as $key => $post ) {
                    $count[ $post['sa_id'] ] = PostType::get_instance()->update_status([
                        'sa_id'   => $post['sa_id'],
                        'source'  => $post['source'],
                        'enabled' => false,
                    ]);
                }
            }
        }
        return [
            'success' => true,
            'count'   => $count,
        ];
    }


    public function reset( $request ) {
        $analytics = [];
        $count     = 0;
        $params = $request->get_params();
        if ( ! empty( $params['ids'] ) && is_array( $params['ids'] ) ) {
            foreach ( $params['ids'] as $key => $sa_id ) {
                Admin::get_instance()->reset_notifications( [ 'sa_id' => $sa_id ] );
                $count++;
            }
            $analytics = Analytics::get_instance()->get_total_count();
        }
        return [
            'success' => true,
            'count'   => $count,
            'data'    => $analytics,
        ];
    }
}
