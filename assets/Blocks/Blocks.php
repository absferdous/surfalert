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
class Blocks
{
    /**
     * Instance of SurfAlert
     *
     * @var Blocks
     */
    use GetInstance;


    public function __construct()
    {
        StyleHandler::get_instance();
        add_action('init', [$this, 'surfalert_block_init']);
    }

    /**
     * Registers all block assets so that they can be enqueued through Gutenberg in
     * the corresponding context.
     *
     * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
     */
    function surfalert_block_init()
    {
        // We will rebuild the block registration here later,
        // after we have successfully compiled the assets with Vite.
        return;
    }
    function surfalert_render_callback($block_attributes, $content)
    {
        if (! is_admin()) {
            wp_enqueue_style('surfalert-block');
            wp_enqueue_script('surfalert-block-frontend');
        }
        if (is_admin() || $this->isRestUrl()) {
            do_action('sa_ignore_analytics');
        }
        $sa_id      = ! empty($block_attributes['sa_id']) ? esc_attr($block_attributes['sa_id']) : '';
        $product_id = ! empty($block_attributes['product_id']) ? $block_attributes['product_id'] : '';
        $block_id   = ! empty($block_attributes['blockId']) ? esc_attr($block_attributes['blockId']) : '';
        $html  = '<div class="' . $block_id . ' surfalert-block-wrapper" data-sa_id="' . $sa_id . '">';
        $html .= do_shortcode("[surfalert_inline product_id='{$product_id}' id='{$sa_id}']");
        $html .= '</div>';
        return $html;
    }

    function gutenberg_examples_dynamic_render_callback($block_attributes, $content)
    {
        do_action('sa_ignore_analytics');
        $sa_id          = ! empty($block_attributes['sa_id']) ? esc_attr($block_attributes['sa_id']) : '';
        $product_id     = ! empty($block_attributes['product_id']) ? $block_attributes['product_id'] : '';
        $post_type     = ! empty($block_attributes['post_type']) ? $block_attributes['post_type'] : '';
        $html      = '<div class="' . $block_attributes['blockId'] . ' surfalert-block-wrapper">';
        if ('wp_template' == $post_type) {
            add_filter('sa_is_preview', function () {
                return true;
            });
            $product_id = rand();
        }
        $shortcode = do_shortcode("[surfalert_inline post_type='{$post_type}' product_id='{$product_id}' id='{$sa_id}' show_link=false]");
        if ($shortcode) {
            $html .= $shortcode;
        } else {
            $html .= '<p class="sa-shortcode-notice">' . __('There is no data in this notification.', 'surfalert') . '</p>';
        }
        $html .= '</div>';

        return wp_kses($html, Helper::sa_allowed_html());
    }

    function isRestUrl()
    {
        if (empty($GLOBALS['wp']->query_vars['rest_route'])) {
            return false;
        }
        return true;
    }
}
