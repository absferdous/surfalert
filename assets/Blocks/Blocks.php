<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package surfalert
 */

namespace SurfAlert\Blocks;

use SurfAlert\Core\Helper;
use SurfAlert\GetInstance;

/**
 *
 * @method static Blocks get_instance($args = null)
 */
class Blocks {
    /**
     * Instance of SurfAlert
     *
     * @var Blocks
     */
    use GetInstance;


    public function __construct() {
        StyleHandler::get_instance();
        add_action( 'init', [ $this, 'surfalert_block_init' ] );
    }

    /**
     * Registers all block assets so that they can be enqueued through Gutenberg in
     * the corresponding context.
     *
     * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
     */
    function surfalert_block_init() {
        // Skip block registration if Gutenberg is not enabled/merged.
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }
        $dir = dirname( __FILE__ );

        // Enqueue Controls CSS & JS
        $controls_css = 'controls/dist/index.css';
        wp_register_style(
            'surfalert-block-controls-css',
            plugins_url( $controls_css, __FILE__ ),
            [],
            filemtime( "{$dir}/{$controls_css}" )
        );

        $asset_file = include SURFALERT_PATH . 'blocks/controls/dist/index.asset.php';
        $index_js   = 'controls/dist/index.js';
        wp_register_script(
            'surfalert-block-controls',
            plugins_url( $index_js, __FILE__ ),
            $asset_file['dependencies'],
            $asset_file['version'],
            false
        );

        $asset_file                   = include SURFALERT_PATH . 'blocks/surfalert/index.asset.php';
        $asset_file['dependencies'][] = 'surfalert-pro-blocks-edit-post';
        $index_js                     = 'surfalert/index.js';
        wp_register_script(
            'surfalert-block-editor',
            plugins_url( $index_js, __FILE__ ),
            array_merge($asset_file['dependencies'], ['surfalert-block-controls']),
            $asset_file['version']
        );

        $editor_css = 'surfalert/editor.css';
        wp_register_style(
            'surfalert-block-editor',
            plugins_url( $editor_css, __FILE__ ),
            array( 'surfalert-block-controls-css' ),
            filemtime( "{$dir}/{$editor_css}" )
        );

        $style_css = 'surfalert/style.css';
        wp_register_style(
            'surfalert-block',
            plugins_url( $style_css, __FILE__ ),
            [],
            filemtime( "{$dir}/{$style_css}" )
        );
        wp_register_script(
            'surfalert-block-frontend',
            plugins_url( 'surfalert/frontend.js', __FILE__ ),
            [],
            filemtime( "{$dir}/surfalert/frontend.js" ),
            true
        );
        wp_localize_script('surfalert-block-frontend', 'surfalertBlockRest', [
            'root'      => rest_url(),
        ]);
        register_block_type( 'surfalert-pro/surfalert',
            [
                'editor_script'   => 'surfalert-block-editor',
                'editor_style'    => 'surfalert-block-editor',
                // 'style'           => 'surfalert-block',
                // 'script'          => 'surfalert-block-frontend',
                'render_callback' => [ $this, 'surfalert_render_callback' ],
                'attributes'      => array(
                    'sa_id'   => array(
                        'type' => 'string',
                    ),
                    'blockId' => array(
                        'type' => 'string',
                    ),
                    'product_id' => array(
                        'type' => 'string',
                    ),
                ),
            ]
        );
        register_block_type( 'surfalert-pro/surfalert-render',
            [
                'render_callback' => [ $this, 'gutenberg_examples_dynamic_render_callback' ],
                'attributes'      => array(
                    'sa_id'   => array(
                        'type' => 'string',
                    ),
                    'blockId' => array(
                        'type' => 'string',
                    ),
                    'product_id' => array(
                        'type' => 'string',
                    ),
                    'post_type' => array(
                        'type' => 'string',
                    ),
                ),
            ]
        );
    }

    function surfalert_render_callback( $block_attributes, $content ) {
        if( ! is_admin() ){
            wp_enqueue_style('surfalert-block');
            wp_enqueue_script('surfalert-block-frontend');
        }
        if ( is_admin() || $this->isRestUrl() ) {
            do_action( 'sa_ignore_analytics' );
        }
        $sa_id      = ! empty( $block_attributes['sa_id'] ) ? esc_attr($block_attributes['sa_id']) : '';
        $product_id = ! empty( $block_attributes['product_id'] ) ? $block_attributes['product_id'] : '';
        $block_id   = ! empty( $block_attributes['blockId'] ) ? esc_attr($block_attributes['blockId']) : '';
        $html  = '<div class="' . $block_id . ' surfalert-block-wrapper" data-sa_id="' . $sa_id . '">';
        $html .= do_shortcode( "[surfalert_inline product_id='{$product_id}' id='{$sa_id}']" );
        $html .= '</div>';
        return $html;
    }

    function gutenberg_examples_dynamic_render_callback( $block_attributes, $content ) {
        do_action( 'sa_ignore_analytics' );
        $sa_id          = ! empty( $block_attributes['sa_id'] ) ? esc_attr($block_attributes['sa_id']) : '';
        $product_id     = ! empty( $block_attributes['product_id'] ) ? $block_attributes['product_id'] : '';
        $post_type     = ! empty( $block_attributes['post_type'] ) ? $block_attributes['post_type'] : '';
        $html      = '<div class="' . $block_attributes['blockId'] . ' surfalert-block-wrapper">';
        if( 'wp_template' == $post_type ) {
            add_filter('sa_is_preview',function(){
                return true;
            });
            $product_id = rand();
        }
        $shortcode = do_shortcode( "[surfalert_inline post_type='{$post_type}' product_id='{$product_id}' id='{$sa_id}' show_link=false]" );
        if ( $shortcode ) {
            $html .= $shortcode;
        } else {
            $html .= '<p class="sa-shortcode-notice">' . __( 'There is no data in this notification.', 'surfalert' ) . '</p>';
        }
        $html .= '</div>';

        return wp_kses($html, Helper::sa_allowed_html());
    }

    function isRestUrl() {
        if ( empty( $GLOBALS['wp']->query_vars['rest_route'] ) ) {
            return false;
        }
        return true;
    }

}
