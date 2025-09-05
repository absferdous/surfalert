<?php
/**
 * ConvertKit Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\ConvertKit;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * ConvertKit Extension
 * @method static ConvertKit get_instance($args = null)
 */
class ConvertKit extends Extension {
    /**
     * Instance of ConvertKit
     *
     * @var ConvertKit
     */
    use GetInstance;

    public $priority        = 10;
    public $id              = 'convertkit';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/convertkit.png';
    public $doc_link        = 'https://surfalert.com/docs/contact-form-submission-alert/';
    public $types           = 'email_subscription';
    public $module          = 'modules_convertkit';
    public $module_priority = 15;
    public $is_pro          = true;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('ConvertKit', 'surfalert');
        $this->module_title = __('ConvertKit', 'surfalert');
    }

    /**
     * Get data for ConvertKit Extension.
     *
     * @param array $args Settings arguments.
     * @return array
     */
    public function get_data( $args = array() ){
        return 'Hello From ConvertKit';
    }

    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">signed in & retrieved your API key from ConvertKit account</a> to use its campaign & email subscriptions data. For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a target="_blank" href="%3$s">Watch video tutorial</a> to learn quickly</p>
		<p>👉 SurfAlert <a target="_blank" href="%4$s">Integration with ConvertKit</a></p>
		<p><strong>Recommended Blog:</strong></p>
		<p>🔥 Connect <a target="_blank" href="%5$s">SurfAlert With ConvertKit</a>: Grow Your Audience By Leveraging Social Proof</p>', 'surfalert'),
        'https://app.convertkit.com/users/login',
        'https://surfalert.com/docs/convertkit-alert/',
        'https://youtu.be/lk_KMSBkEbY',
        'https://surfalert.com/integrations/convertkit/',
        'https://wpdeveloper.com/convertkit-social-proof/'
        );
    }
}
