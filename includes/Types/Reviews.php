<?php

/**
 * Extension Abstract
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Types;

use SurfAlert\Core\Rules;
use SurfAlert\Types\Traits\Reviews as TraitsReviews;
use SurfAlert\Extensions\GlobalFields;
use SurfAlert\GetInstance;
use SurfAlert\Modules;

/**
 * Extension Abstract for all Extension.
 * @method static Reviews get_instance($args = null)
 */
class Reviews extends Types {
    /**
     * Instance of Admin
     *
     * @var Admin
     */
    use GetInstance;
    use TraitsReviews;

    public $priority = 20;
    public $themes = [];
    public $res_themes = [];
    public $module = [
        'modules_wordpress',
        'modules_woocommerce',
        'modules_reviewx',
        'modules_zapier',
        'modules_freemius',
    ];
    public $default_source = 'wp_reviews';
    public $default_theme  = 'reviews_total-rated';
    public $link_type      = 'review_page';


    /**
     * Initially Invoked when initialized.
     */
    public function __construct() {
        add_filter('sa_link_types', [$this, 'link_types']);
        parent::__construct();
        $this->id    = 'reviews';
    }

    public function init() {
        parent::init();
        $this->title = __('Reviews', 'surfalert');
        $this->themes = [
            'total-rated'     => [
                'source'                => SURFALERT_ADMIN_URL . 'images/extensions/themes/wporg/total-rated.png',
                'image_shape' => 'square',
                'template'  => [
                    'first_param'         => 'tag_rated',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('people rated', 'surfalert'),
                    'third_param'         => 'tag_plugin_name',
                    'fourth_param'        => 'tag_rating',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ]
            ],
            'reviewed'     => [
                'source'                => SURFALERT_ADMIN_URL . 'images/extensions/themes/wporg/reviewed.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         =>  'tag_username',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('just reviewed', 'surfalert'),
                    'third_param'         => 'tag_plugin_name',
                    'fourth_param'        => 'tag_rating',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ]
            ],
            'review_saying' => [
                'source'               => SURFALERT_ADMIN_URL . 'images/extensions/themes/wporg/saying-review.png',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_username',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('saying', 'surfalert'),
                    'third_param'         => 'tag_title',
                    'custom_third_param'  => __('Excellent', 'surfalert'),
                    'review_fourth_param' => __('about', 'surfalert'),
                    'fifth_param'         => 'tag_plugin_name',
                    'sixth_param'         => 'tag_custom',
                    'custom_sixth_param'  => __('Try it now', 'surfalert'),
                ]
            ],
            'review-comment' => [
                'source'                => SURFALERT_ADMIN_URL . 'images/extensions/themes/wporg/review-with-comment.jpg',
                'image_shape' => 'rounded',
                'template'  => [
                    'first_param'         => 'tag_username',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('just reviewed', 'surfalert'),
                    'third_param'         => 'tag_plugin_review',
                    'fourth_param'        => 'tag_rating',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ]
            ],
            'review-comment-2' => [
                'source'                => SURFALERT_ADMIN_URL . 'images/extensions/themes/wporg/review-with-comment-2.jpg',
                'template'  => [
                    'first_param'         => 'tag_username',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('just reviewed', 'surfalert'),
                    'third_param'         => 'tag_plugin_review',
                    'fourth_param'        => 'tag_rating',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ]
            ],
            'review-comment-3' => [
                'source'                => SURFALERT_ADMIN_URL . 'images/extensions/themes/wporg/review-with-comment-3.jpg',
                'image_shape' => 'circle',
                'template'  => [
                    'first_param'         => 'tag_username',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('just reviewed', 'surfalert'),
                    'third_param'         => 'tag_plugin_review',
                    'fourth_param'        => 'tag_time',
                    'custom_fourth_param' => __('Some time ago', 'surfalert'),
                ]
            ],
        ];
        $this->res_themes = [
            'res-theme-one'     => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_reviews/sa-review-res-theme-1.png',
                'image_shape' => 'square',
                'template'    => [
                    'res_first_param'  => 'tag_rated',
                    'res_second_param' => __('people rated', 'surfalert'),
                    'res_third_param'  => 'tag_plugin_name',
                ],
                'is_pro' => true,
            ],
            'res-theme-two'     => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_reviews/sa-review-res-theme-2.png',
                'image_shape' => 'square',
                'template'    => [
                    'res_first_param'  => 'tag_username',
                    'res_second_param' => __('just reviewed', 'surfalert'),
                    'res_third_param'  => 'tag_plugin_name',
                ],
                'is_pro' => true,
            ],
            'res-theme-three'     => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_reviews/sa-review-res-theme-3.png',
                'image_shape' => 'square',
                'template'    => [
                    'res_first_param'  => 'tag_username',
                    'res_second_param' => __('just reviewed', 'surfalert'),
                    'res_third_param'  => 'tag_plugin_name',
                ],
                'is_pro' => true,
            ],
            'rating-res-theme-four'     => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_reviews/sa-review-res-theme-4.png',
                'image_shape' => 'square',
                'template'    => [
                    'res_first_param'  => 'tag_username',
                    'res_second_param' => __('just reviewed', 'surfalert'),
                    'res_third_param'  => 'tag_rating',
                ],
                'is_pro' => true,
            ],
            'rating-res-theme-five'     => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_reviews/sa-review-res-theme-5.png',
                'image_shape' => 'square',
                'template'    => [
                    'res_first_param'  => 'tag_username',
                    'res_second_param' => __('just reviewed', 'surfalert'),
                    'res_third_param'  => 'tag_rating',
                ],
                'is_pro' => true,
            ],
            'rating-res-theme-six'     => [
                'source'      => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_reviews/sa-review-res-theme-6.png',
                'image_shape' => 'square',
                'template'    => [
                    'res_first_param'  => 'tag_username',
                    'res_second_param' => __('just reviewed', 'surfalert'),
                    'res_third_param'  => 'tag_rating',
                ],
                'is_pro' => true,
            ],
        ];

        $this->templates = [
            'wp_reviews_template_new'  => [
                'first_param' => [
                    'tag_username' => __('Username', 'surfalert'),
                    'tag_rated'    => __('Rated', 'surfalert'),
                ],
                'third_param' => [
                    'tag_plugin_name'     => __('Plugin Name', 'surfalert'),
                    'tag_plugin_review'   => __('Review', 'surfalert'),
                    'tag_anonymous_title' => __('Anonymous Title', 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_rating'   => __('Rating', 'surfalert'),
                    'tag_time'     => __('Definite Time', 'surfalert'),
                ],
                '_themes' => [
                    'reviews_total-rated',
                    'reviews_reviewed',
                    'reviews_review-comment',
                    'reviews_review-comment-2',
                    'reviews_review-comment-3',
                ],
            ],
            'review_saying_template_new' => [
                'first_param' => [
                    'tag_username' => __('Username', 'surfalert'),
                ],
                'third_param' => [
                    'tag_title'           => __('Review Title', 'surfalert'),
                    'tag_anonymous_title' => __('Anonymous Title', 'surfalert'),
                ],
                'fifth_param' => [
                    'tag_plugin_name' => __('Plugin Name', 'surfalert'),
                ],
                'sixth_param' => [
                    // @todo maybe add some predefined texts.
                ],
                '_themes' => [
                    'reviews_review_saying',
                ],
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
