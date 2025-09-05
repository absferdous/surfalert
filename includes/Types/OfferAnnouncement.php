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
 * @method static OfferAnnouncement get_instance($args = null)
 */
class OfferAnnouncement extends Types {
    /**
     * Instance of OfferAnnouncement
     *
     * @var OfferAnnouncement
     */
    use GetInstance;
    public $priority       = 36;
    public $module         = ['modules_announcements'];
    public $id             = 'offer_announcement';
    public $default_source = 'announcements';
    public $default_theme  = 'announcements_theme-one';
    public $is_pro         = true;
    // public $link_type      = 'comment_url';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct() {
        parent::__construct();
        
        // add_filter('sa_link_types', [$this, 'link_types']);
    }

    public function init()
    {
        parent::init();
        $this->title = __('Discount Alert', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/configure-discount-alert/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>Discount Alert by SurfAlert will allow you to display offers/discounts of your products/services on your website interactively & easily.</span>
                <video id="pro_alert_video_popup" type="text/html" allowfullscreen width="450" height="235" autoplay loop muted>
                    <source src="https://surfalert.com/wp-content/uploads/2024/01/NX-Discount-Alert-1.mp4" type="video/mp4">
                </video>
            ', 'surfalert')
        ];
    }

    /**
     * Hooked to sa_before_metabox_load action.
     *
     * @return void
     */
    public function init_fields() {
        parent::init_fields();
        // add_filter('sa_content_trim_length_dependency', [$this, 'content_trim_length_dependency']);

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
