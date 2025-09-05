<?php

/**
 * Extension Abstract
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Types;

use SurfAlert\Core\Rules;
use SurfAlert\Extensions\GlobalFields;
use SurfAlert\GetInstance;
use SurfAlert\Modules;

/**
 * Extension Abstract for all Extension.
 * @method static Video get_instance($args = null)
 */
class Video extends Types {
    /**
     * Instance of Video
     *
     * @var Video
     */
    use GetInstance;

    public $priority = 60;
    public $themes = [];
    public $module = [
        'modules_google_youtube',
    ];
    public $default_source = 'youtube';
    public $is_pro = true;
    // public $default_theme  = '';
    // public $link_type      = '';


    /**
     * Initially Invoked when initialized.
     */
    public function __construct() {
        parent::__construct();
        $this->id    = 'video';
    }

    public function init()
    {
        parent::init();
        $this->title = __('Video', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/youtube-video-activities-popups/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>SurfAlert will help you increasing engagement of your YouTube channel and gaining more credibility.</span>
                <video id="pro_alert_video_popup" type="text/html" allowfullscreen width="450" height="235" autoplay loop muted>
                    <source src="https://surfalert.com/wp-content/uploads/2024/01/How-To-Show-YouTube-Activities-Popup-With-SurfAlert.mp4" type="video/mp4">
                </video>
            ', 'surfalert')
        ];
    }

}
