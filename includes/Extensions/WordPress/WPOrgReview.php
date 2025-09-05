<?php

/**
 * WPOrgReview Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\WordPress;

use SurfAlert\Admin\Cron;
use SurfAlert\Core\PostType;
use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;
use SurfAlert\Extensions\GlobalFields;

/**
 * WPOrgReview Extension
 * @method static WPOrgReview get_instance($args = null)
 */
class WPOrgReview extends Extension {
    /**
     * Instance of WPOrgReview
     *
     * @var WPOrgReview
     */
    use GetInstance;
    use WordPress;

    /**
     * Instance of WPOrg_Helper
     *
     * @var [WPOrg_Helper]
     */
    public $helper;

    public $priority = 2;
    public $id       = 'wp_reviews';
    public $img      = SURFALERT_ADMIN_URL . 'images/extensions/sources/wordpress.png';
    public $doc_link = 'https://surfalert.com/docs-category/configurations/';
    public $types    = 'reviews';
    public $module   = 'modules_wordpress';
    public $cron_schedule = 'sa_wp_review_interval';
	public $module_priority = 2;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct() {
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('WP.Org Reviews', 'surfalert');
        $this->module_title = __('WordPress', 'surfalert');
    }

    public function init() {
        parent::init();

        // add_filter('sa_notification_link', array($this, 'notification_link'), 10, 2);

        add_filter("sa_filtered_entry_{$this->id}", array($this, 'conversion_data'), 10, 2);

        if ($this->helper === null) {
            $this->helper = new WPOrg_Helper();
        }
    }

    public function init_fields() {
        parent::init_fields();
        add_filter('sa_content_fields', [$this, 'content_fields']);
    }

    /**
     * This functions is hooked
     *
     * @return void
     */
    public function admin_actions() {
        parent::admin_actions();

        add_action("sa_cron_update_data_{$this->id}", array($this, 'update_data'), 10, 2);
    }

    /**
     * This functions is hooked
     *
     * @hooked sa_public_action
     *
     * @return void
     */
    public function public_actions() {
        parent::public_actions();

        // Show only single entry if total-rated theme.
        add_filter( 'sa_frontend_get_entries', [$this, 'total_rated_theme'], 10, 3);
        // Slice product name
        add_filter( 'sa_frontend_get_entries', [$this, 'slice_product_name'], 10, 3);
    }

    /**
     * Truncates product names in entries based on device-specific length settings.
     * 
     * @param array $entries Array of product entries to process.
     * @param array $ids Array of IDs to process (not used here).
     * @param array $notifications Notification settings keyed by `sa_id`.
     * @return array Updated entries array with truncated product names.
     */
    public function slice_product_name($entries, $ids, $notifications) {
        foreach ($entries as $key => $entry) {
            if($entry['source'] == $this->id){
                $sa_id        = $entry['sa_id'];
                $settings     = $notifications[$sa_id];
                if ( !empty( $settings['wp_reviews_product_name_length'] ) && !empty( $entry['plugin_name'] ) ) {
                    $text                       = $entry['plugin_name'] ?? '';
                    $maxLength                  = wp_is_mobile()  ? ($settings['wp_reviews_product_name_length']['mobile'] ?? 0)  : ($settings['wp_reviews_product_name_length']['desktop'] ?? 0);
                    $entry['plugin_name'] = (strlen($text) > $maxLength && $maxLength > 0)  ? substr($text, 0, $maxLength) . '...' : $text;
                }
                $entries[$key] = $entry;
            }
        }

        return $entries;
    }

    /**
     * Get data for WooCommerce Extension.
     *
     * @param array $args Settings arguments.
     * @return mixed
     */
    public function content_fields($fields) {
        $content_fields = &$fields['content']['fields'];

        $content_fields['wp_reviews_product_type'] = [
            'label'    => __('Product Type', 'surfalert'),
            'name'     => 'wp_reviews_product_type',
            'type'     => 'select',
            'priority' => 79,
            'default'  => 'plugin',
            'options'  => GlobalFields::get_instance()->normalize_fields([
                'plugin' => __('Plugin', 'surfalert'),
            ]),
            'rules'  => ['is', 'source', $this->id],
        ];

        $content_fields['wp_reviews_slug'] = [
            'label'    => __('Slug', 'surfalert'),
            'name'     => 'wp_reviews_slug',
            'type'     => 'text',
            'priority' => 80,
            'rules'  => ['is', 'source', $this->id]
        ];
        $content_fields['wp_reviews_product_name_length'] = [
            'name'    => 'wp_reviews_product_name_length',
            'type'    => "responsive-number",
            'label'   => __('Product Name Length', 'surfalert'),
            'rules'   => ['is', 'source', $this->id],
            'default' => [
                "desktop" => 30,
                "mobile"  => 20,
            ],
            'priority' => 90,
            'min'      => 10,
            'controls' => [
                "desktop" => [
                    "icon" => SURFALERT_ADMIN_URL . 'images/responsive/desktop.svg',
                    'size' => 18,
                ],
                "mobile" => [
                    "icon" => SURFALERT_ADMIN_URL . 'images/responsive/mobile.svg',
                    'size' => 12,
                ],
            ],
            'help' => __('Set a max content length for product name.', 'surfalert'),
        ];
        return $fields;
    }

    // @todo Something
    public function fallback_data($data, $saved_data, $settings) {
        // $data['username']         = __('Someone', 'surfalert');
        $data['plugin_name_text'] = __('try it out', 'surfalert');
        $data['anonymous_title']  = __('Anonymous', 'surfalert');
        $data['rating']    = 5;
        return $data;
    }

    public function notification_image($image_data, $data, $settings) {
        if (!$settings['show_default_image']) {
            $image_url = '';
            switch ($settings['show_notification_image']) {
                case 'featured_image':
                    if (isset($data['icons']['2x'])) {
                        $image_url = $data['icons']['2x'];
                    } else {
                        $image_url = isset($data['icons']['1x']) ? $data['icons']['1x'] : '';
                    }
                    break;
                case 'gravatar':
                    if (isset($data['avatar'])) {
                        $avatar = $data['avatar']['src'];
                        $image_url = add_query_arg('s', '200', $avatar);
                    }
                    break;
            }
            $image_data['url'] = $image_url;
        }

        $alt_title = isset($data['plugin_name']) ? $data['plugin_name'] : '';
        $alt_title = empty($alt_title) && isset($data['username']) ? $data['username'] : $alt_title;

        $image_data['alt'] = $alt_title;

        return $image_data;
    }

    public function saved_post($post, $data, $sa_id) {
        $this->update_data($sa_id, $data);
    }

    public function update_data($sa_id, $data = array()) {
        if (empty($sa_id)) {
            return;
        }
        if (empty($data)) {
            $data = PostType::get_instance()->get_post($sa_id);
        }

        $plugin_data = $this->get_plugins_data($sa_id, $data);
        if(empty($plugin_data)){
            return;
        }

        $reviews = $plugin_data['reviews'];
        unset($plugin_data['reviews']);

        // removing old notifications.
        $this->delete_notification(null, $sa_id);
        $entries = [];
        foreach ($reviews as $review) {
            $review = array_merge($review, $plugin_data);
            $entries[] = [
                'sa_id'      => $sa_id,
                'source'     => $this->id,
                'entry_key'  => $review['username'],
                'data'       => $review,
            ];
        }
        $this->update_notifications($entries);
        return $reviews;
    }

    /**
     * This function is responsible for making the notification ready for first time we make the notification.
     *
     * @param string $type
     * @param array $data
     * @return void
     */
    public function get_notification_ready($data = array()) {
        if (!is_null($data['sa_id'])) {
            return $this->update_data($data['sa_id'], $data);
        }
        return [];
    }

    public function get_plugins_data($post_id, $data) {
        if (!$post_id) {
            return;
        }

        $product_type = $data['wp_reviews_product_type'];
        $plugin_slug  = $data['wp_reviews_slug'];

        $reviews = [];

        if (!$plugin_slug) {
            return;
        }

        if ($product_type == 'plugin') {
            $reviews_html = $this->helper->get_plugin_reviews($plugin_slug);
            $reviews      = $this->helper->extract_reviews_from_html($reviews_html, $plugin_slug);
        }

        return $reviews;
    }


    // @todo frontend
    public function conversion_data($saved_data, $settings) {
        $saved_data['name']        = isset($saved_data['name']) ? html_entity_decode($saved_data['name']) : '';
        if(empty($saved_data['rated'])){
            $saved_data['rated'] = isset($saved_data['ratings']) ? $saved_data['ratings']['5'] : '';
        }
        if(empty($saved_data['plugin_name'])){
            $saved_data['plugin_name'] = $saved_data['name'];
        }

        $product_type = $settings['wp_reviews_product_type'];
        if (empty($saved_data['link']) && $product_type == 'plugin' && isset($saved_data['slug'])) {
            //TODO: Its has to be specific reviews link.
            $saved_data['link'] = 'https://wordpress.org/plugins/' . $saved_data['slug'];
        }

        return $saved_data;
    }

    /**
     * Show only single entry if total-rated theme.
     *
     * @param array $entries
     * @param array $ids
     * @return void
     */
    public function total_rated_theme($entries, $ids, $notifications) {
        $sa_ids = [];

        foreach ($entries as $key => $entry) {
            if($entry['source'] == $this->id){
                $sa_id        = $entry['sa_id'];
                $settings     = $notifications[$sa_id];
                $theme        = $settings['theme'];
                $product_type = $settings['wp_reviews_product_type'];
                if($theme === 'reviews_total-rated'){
                    if(!in_array($sa_id, $sa_ids)){
                        $sa_ids[]             = $sa_id;

                        $entry['rated']       = isset($entry['ratings']) ? $entry['ratings']['5'] : '';
                        $entry['name']        = isset($entry['name']) ? html_entity_decode($entry['name']) : '';
                        $entry['plugin_name'] = $entry['name'];
                        $entry['timestamp']   = time();
                        $product_type         = $settings['wp_reviews_product_type'];

                        if (empty($entry['link']) && $product_type == 'plugin' && isset($entry['slug'])) {
                            //TODO: Its has to be specific reviews link.
                            $entry['link'] = 'https://wordpress.org/plugins/' . $entry['slug'];
                        }
                        $entries[$key] = $entry;
                    }
                    else{
                        unset($entries[$key]);
                    }
                }

            }
        }

        return $entries;
    }
}
