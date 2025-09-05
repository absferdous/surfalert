<?php
/**
 * CustomNotification Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\CustomNotification;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * CustomNotification Extension
 * @method static CustomNotificationConversions get_instance($args = null)
 */
class CustomNotificationConversions extends Extension {
    /**
     * Instance of CustomNotificationConversions
     *
     * @var CustomNotificationConversions
     */
    use GetInstance;

    public $priority        = 30;
    public $id              = 'custom_notification_conversions';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/custom.png';
    public $doc_link        = 'https://surfalert.com/docs/custom-notification';
    public $types           = 'conversions';
    public $module          = 'modules_custom_notification';
    public $module_priority = 13;
    public $is_pro          = true;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('Custom Notification', 'surfalert');
        $this->module_title = __('Custom Notification', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/custom-notification/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span style="text-align:left;">Display custom conversion notifications as pop up.</span>
                <iframe id="custom_notification_video" type="text/html" allowfullscreen width="450" height="235"
                src="https://www.youtube.com/embed/OuTmDZ0_TEw">
                </iframe>
            ', 'surfalert')
        ];
    }

    /**
     * Get data for CustomNotification Extension.
     *
     * @param array $args Settings arguments.
     * @return array
     */
    public function get_data( $args = array() ){
        return 'Hello From Custom Notification';
    }

    public function doc(){
        return sprintf(__('<p>You can make custom notification for its all types of campaign. For further assistance, check out our step by step <a target="_blank" href="%1$s">documentation</a>.</p>
		<p>🎦 Watch <a target="_blank" href="%2$s">video tutorial</a> to learn quickly</p>
		<p><strong>Recommended Blog:</strong></p>
		<p>🔥 How to <a target="_blank" href="%3$s">Display Custom Notification Alerts</a> On Your Website Using SurfAlert</p>', 'surfalert'),
        'https://surfalert.com/docs/custom-notification/',
        'https://www.youtube.com/watch?v=OuTmDZ0_TEw',
        'https://wpdeveloper.com/custom-surfalert-alert-fomo/'
        );
    }
}
