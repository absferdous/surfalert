<?php
/**
 * Envato Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\Envato;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * Envato Extension
 * @method static Envato get_instance($args = null)
 */
class Envato extends Extension {
    /**
     * Instance of Envato
     *
     * @var Envato
     */
    use GetInstance;

    public $priority        = 25;
    public $id              = 'envato';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/envato.png';
    public $doc_link        = 'https://surfalert.com/docs/envato-sales-notification';
    public $types           = 'conversions';
    public $module          = 'modules_envato';
    public $module_priority = 17;
    public $is_pro          = true;
    public $version         = '1.2.0';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('Envato', 'surfalert');
        $this->module_title = __('Envato', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/envato-sales-notification/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>A resourceful online marketplace for digital assets and services.</span>
                <iframe id="email_subscription_video" type="text/html" allowfullscreen width="450" height="235"
                src="https://www.youtube.com/embed/-df_6KHgr7I">
                </iframe>
            ', 'surfalert')
        ];
    }

    /**
     * Get data for Envato Extension.
     *
     * @param array $args Settings arguments.
     * @return array
     */
    public function get_data( $args = array() ){
        return 'Hello From Custom Notification';
    }

    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">created & signed in to Envato account</a> to use its campaign & product sales data.  For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a target="_blank" href="%3$s">Watch video tutorial</a> to learn quickly</p>
		<p>👉 SurfAlert <a target="_blank" href="%4$s">Integration with Envato</a></p>', 'surfalert'),
        'https://account.envato.com/sign_in?to=envato-api',
        'https://surfalert.com/docs/envato-sales-notification/',
        'https://youtu.be/-df_6KHgr7I',
        'https://surfalert.com/integrations/envato/'
        );
    }
}
