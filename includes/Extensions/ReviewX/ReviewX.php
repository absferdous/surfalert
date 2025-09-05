<?php
/**
 * ReviewX Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\ReviewX;

use SurfAlert\Core\Rules;
use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;
use SurfAlert\Extensions\WooCommerce\Woo;
use SurfAlert\Extensions\WooCommerce\WooReviews;
use SurfAlert\SurfAlert;
use SurfAlert\Types\Conversions;
use SurfAlert\Types\CustomNotification;
use SurfAlert\Types\DownloadStats;

/**
 * ReviewX Extension Class
 */
class ReviewX extends WooReviews {
    protected static $instance = null;

    public $priority              = 15;
    public $id                    = 'reviewx';
    public $img                   = SURFALERT_ADMIN_URL . 'images/extensions/sources/reviewx.png';
    public $doc_link              = 'https://surfalert.com/docs/reviewx-notification-alerts/';
    public $types                 = 'reviews';
    public $module                = 'modules_reviewx';
    public $module_priority       = 4;
    // public $class                 = '\ReviewX';
    public $function              = 'rvx_wpdrill_init';
    public $default_theme         = 'reviewx_total-rated';
    public $exclude_custom_themes = true;

    /**
     * Get the instance of called class.
     *
     * @return ReviewX
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
        $this->title = __('ReviewX', 'surfalert');
        $this->module_title = __('ReviewX', 'surfalert');
        $this->themes = [
            'total-rated'     => [
                'source'                => SURFALERT_ADMIN_URL . 'images/extensions/themes/wporg/total-rated.png',
                'image_shape' => 'square',
                'template'  => [
                    'first_param'         => 'tag_rated',
                    'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('people rated', 'surfalert'),
                    'third_param'         => 'tag_product_title',
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
                    'third_param'         => 'tag_product_title',
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
                    'fifth_param'         => 'tag_product_title',
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
        $this->templates = [
            'reviewx_template_new'  => [
                'first_param' => [
                    'tag_username' => __('Username', 'surfalert'),
                    'tag_rated'    => __('Rated', 'surfalert'),
                ],
                'third_param' => [
                    'tag_product_title' => __('Product Title', 'surfalert'),
                    'tag_plugin_review'   => __('Review', 'surfalert'),
                    'tag_anonymous_title' => __('Anonymous Title', 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_rating'   => __('Rating', 'surfalert'),
                    'tag_time'     => __('Definite Time', 'surfalert'),
                ],
                '_themes' => [
                    'reviewx_total-rated',
                    'reviewx_reviewed',
                    'reviewx_review-comment',
                    'reviewx_review-comment-2',
                    'reviewx_review-comment-3',
                ],
            ],
            'reviewx_saying_template_new' => [
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
                    'reviewx_review_saying',
                ],
            ],
        ];
    }
    /**
     * This functions is hooked
     *
     * @return void
     */
    public function admin_actions() {
        parent::admin_actions();
        if(SurfAlert::get_instance()->is_pro()){
            add_filter("sa_can_entry_{$this->id}", array(Conversions::get_instance(), 'sa_can_entry'), 10, 3);
        }
    }

    public function source_error_message($messages) {
        if (!$this->class_exists()) {
            $url = admin_url('plugin-install.php?s=ReviewX&tab=search&type=term');
            $messages[$this->id] = [
                'message' => sprintf( '%s <a href="%s" target="_blank">%s</a> %s.',
                    __( 'You have to install', 'surfalert' ),
                    $url,
                    __( 'ReviewX', 'surfalert' ),
                    __( 'plugin.', 'surfalert' )
                ),
                'html' => true,
                'type' => 'error',
                'rules' => Rules::is('source', $this->id),
            ];
        }
        return $messages;
    }

    /**
     * This function is responsible for making ready the comments data!
     *
     * @param int|WP_Comment $comment
     * @return void
     */
    public function add($comment) {
        $comment_data = [];
        if (!$comment instanceof \WP_Comment) {
            $comment_id = intval($comment);
            $comment = get_comment($comment_id, 'OBJECT');
        }
        if ($comment->comment_type !== 'review') {
            return;
        }

        $comment_data['id']         = $comment->comment_ID;
        $comment_data['product_id'] = $comment->comment_post_ID;
        $comment_data['content']    = $comment->comment_content;
        $comment_data['link']       = get_comment_link($comment->comment_ID);
        $comment_data['post_title'] = get_the_title($comment->comment_post_ID);
        $comment_data['post_link']  = get_permalink($comment->comment_post_ID);
        $comment_data['timestamp']  = get_gmt_from_date($comment->comment_date);
        $comment_data['rating']     = get_comment_meta($comment->comment_ID, 'rating', true);
        $comment_data['title']      = get_comment_meta($comment->comment_ID, 'reviewx_title', true);

        $comment_data['ip']  = $comment->comment_author_IP;

        if ($comment->user_id) {
            $comment_data['user_id']    = $comment->user_id;
            $user                       = get_userdata($comment->user_id);
            $comment_data['first_name'] = $user->first_name;
            $comment_data['last_name']  = $user->last_name;
            $comment_data['username']  = $user->display_name;
            $comment_data['name']       = $user->first_name . ' ' . mb_substr($user->last_name, 0, 1);
            $trimed = trim($comment_data['name']);
            if (empty($trimed)) {
                $comment_data['name'] = $user->user_nicename;
            }
        } else {
            $commenter_name = get_comment_author($comment->comment_ID);
            $comment_data['username'] = $commenter_name;
            $commenter_name = explode(' ', $commenter_name);
            if (isset($commenter_name[0])) {
                $comment_data['first_name'] = $commenter_name[0];
            }
            $commenter_count = count($commenter_name);
            if (isset($commenter_name[$commenter_count - 1])) {
                $comment_data['last_name'] = $commenter_name[$commenter_count - 1];
            }
        }
        $comment_data['email'] = get_comment_author_email($comment->comment_ID);
        return $comment_data;
    }

    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">WooCommerce</a> & <a target="_blank" href="%2$s">ReviewX</a> installed & activated to use this campaign. For further assistance, check out our step by step <a target="_blank" href="%3$s">documentation</a>.</p>
		<p><strong>Recommended Blog:</strong></p>
		<p>🚀 How to <a target="_blank" href="%4$s">boost WooCommerce Sales</a> Using SurfAlert</p>', 'surfalert'),
        'https://wordpress.org/plugins/woocommerce/',
        'https://wordpress.org/plugins/reviewx/',
        'https://surfalert.com/docs/reviewx-notification-alerts',
        'https://wpdeveloper.com/ecommerce-sales-social-proof/'
        );
    }
}
