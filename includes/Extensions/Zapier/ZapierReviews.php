<?php
/**
 * Zapier Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\Zapier;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * Zapier Extension
 * @method static ZapierReviews get_instance($args = null)
 */
class ZapierReviews extends Extension {
    /**
     * Instance of Zapier
     *
     * @var Zapier
     */
    use GetInstance;
    use Zapier;

    public $priority = 25;
    public $id       = 'zapier_reviews';
    public $img      = SURFALERT_ADMIN_URL . 'images/extensions/sources/zapier.png';
    public $doc_link = 'https://surfalert.com/docs/zapier-notification-alert/';
    public $types    = 'reviews';
    public $module   = 'modules_zapier';
    public $is_pro   = true;
    public $module_priority = 16;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('Zapier', 'surfalert');
        $this->module_title = __('Zapier', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/zapier-notification-alert/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>Display review alerts from popular social media networks & encourage visitors to place trust in your business.</span>
            ', 'surfalert')
        ];
    }

    /**
     * Get data for Zapier Extension.
     *
     * @param array $args Settings arguments.
     * @return array
     */
    public function get_data( $args = array() ){
        return 'Hello From Zapier';
    }

    public function _doc(){
        return '
        <ul class="reviews sa-template-keys">
            <li><span>' . __('Field Name:', 'surfalert') . '</span> <strong>' . __('Field Key', 'surfalert') . '</strong></li>
            <li><span>' . __('Username:', 'surfalert') . '</span> <strong>username</strong></li>
            <li><span>' . __('Email:', 'surfalert') . '</span> <strong>email</strong></li>
            <li><span>' . __('Rated:', 'surfalert') . '</span> <strong>rated</strong></li>
            <li><span>' . __('Plugin Name:', 'surfalert') . '</span> <strong>plugin_name</strong></li>
            <li><span>' . __('Plugin Review:', 'surfalert') . '</span> <strong>plugin_review</strong></li>
            <li><span>' . __('Review Title:', 'surfalert') . '</span> <strong>title</strong></li>
            <li><span>' . __('Anonymous Title:', 'surfalert') . '</span> <strong>anonymous_title</strong></li>
            <li><span>' . __('Rating:', 'surfalert') . '</span> <strong>rating</strong></li>
            <li><span>' . __('Definite Time:', 'surfalert') . '</span> <strong>timestamp</strong></li>
            <li><span>' . __('Some time ago:', 'surfalert') . '</span> <strong>sometime</strong></li>
        </ul>';
    }
}
