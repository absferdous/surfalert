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
 * @method static Comments get_instance($args = null)
 */
class Comments extends Types {
    /**
     * Instance of Admin
     *
     * @var Admin
     */
    use GetInstance;
    public $priority       = 35;
    public $module         = ['modules_wordpress'];
    public $id             = 'comments';
    public $default_source = 'wp_comments';
    public $default_theme  = 'comments_theme-one';
    public $link_type      = 'comment_url';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct() {
        parent::__construct();

        add_filter('sa_link_types', [$this, 'link_types']);
    }

    public function init()
    {
        parent::init();
        $this->title = __('Comments', 'surfalert');
        // sa_comment_colored_themes
        $this->themes = [
            'theme-one'        => [
                'source'  => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-comment-theme-2.jpg',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_title',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
            ],
            'theme-two'        => [
                'source'  => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-comment-theme-1.jpg',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_title',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
            ],
            'theme-three'      => [
                'source'  => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-comment-theme-3.jpg',
                'image_shape' => 'square',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_title',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
            ],
            'theme-six-free'   => [
                'source'  => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-comment-theme-4.jpg',
                'image_shape' => 'rounded',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
            ],
            'theme-seven-free' => [
                'source'  => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-comment-theme-5.jpg',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
            ],
            'theme-eight-free' => [
                'source'  => SURFALERT_ADMIN_URL . 'images/extensions/themes/sa-comment-theme-6.jpg',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_comment',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
            ],
            'theme-four'       => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-comment-theme-four.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_title',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
            ),
            'theme-five' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/sa-comment-theme-five.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_name',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('commented on', 'surfalert'),
                    'third_param'         => 'tag_post_title',
                    'custom_third_param'  => __('Anonymous Post', 'surfalert'),
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ],
            ),
            // @todo pro fix
            'maps_theme' => array(
                'is_pro' => true,
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/maps-theme-comments.png',
                'image_shape' => 'square',
                'show_notification_image' => 'maps_image',
            ),
        ];
        $this->res_themes = [
            'res-theme-one'        => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-1.png',
                '_template' => 'comments_template_new',
                'is_pro'    => true,
            ],
            'res-theme-two'        => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-2.png',
                '_template' => 'comments_template_new',
                'is_pro'    => true,
            ],
            'res-theme-three'      => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-3.png',
                '_template' => 'comments_template_new',
                'is_pro'    => true,
            ],
            'res-theme-four'   => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-4.png',
                '_template' => 'comments_template_with_comments',
                'is_pro'    => true,
            ],
            'res-theme-five' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-5.png',
                '_template' => 'comments_template_with_comments',
                'is_pro'    => true,
            ],
            'res-theme-six' => [
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-6.png',
                '_template' => 'comments_template_with_comments',
                'is_pro'    => true,
            ],
            'res-theme-seven'       => array(
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-7.png',
                '_template' => 'comments_template_new',
                'is_pro'    => true,
            ),
            'res-theme-eight' => array(
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-8.png',
                '_template' => 'comments_template_new',
                'is_pro'    => true,
            ),
            // @todo pro fix
            'res-theme-nine' => array(
                'source'    => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_themes/sa-comment-theme-9.png',
                '_template' => 'maps_template_new',
                'is_pro'    => true,
            ),
        ];
        $this->templates = [
            'comments_template_new' => [
                'first_param' => GlobalFields::get_instance()->common_name_fields(true),
                'third_param' => [
                    'tag_post_title'     => __('Post Title', 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_time' => __('Definite Time', 'surfalert'),
                ],
                '_themes' => [
                    'comments_theme-one',
                    'comments_theme-two',
                    'comments_theme-three',
                    'comments_theme-four',
                    'comments_theme-five',
                ],
            ],
            'comments_template_with_comments' => [
                'first_param' => GlobalFields::get_instance()->common_name_fields(true),
                'third_param' => [
                    'tag_post_title'     => __('Post Title', 'surfalert'),
                    'tag_post_comment'   => __('Post Comment', 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_time' => __('Definite Time', 'surfalert'),
                ],
                '_themes' => [
                    'comments_theme-six-free',
                    'comments_theme-seven-free',
                    'comments_theme-eight-free',
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
        add_filter('sa_content_trim_length_dependency', [$this, 'content_trim_length_dependency']);

    }

    /**
     * Adds option to Link Type field in Content tab.
     *
     * @param array $options
     * @return array
     */
    public function link_types($options){
        $_options = GlobalFields::get_instance()->normalize_fields([
            'comment_url'      => __('Comment URL', 'surfalert'),
        ], 'type', $this->id);

        return array_merge($options, $_options);
    }


    /**
     * This method is an implementable method for All Extension coming forward.
     *
     * @param array $args Settings arguments.
     * @return mixed
     */
    public function content_trim_length_dependency($dependency) {
        $dependency[] = 'comments_theme-six-free';
        $dependency[] = 'comments_theme-seven-free';
        $dependency[] = 'comments_theme-eight-free';
        return $dependency;
    }
}
