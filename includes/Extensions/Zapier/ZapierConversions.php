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
 * @method static ZapierConversions get_instance($args = null)
 */
class ZapierConversions extends Extension {
    /**
     * Instance of Zapier
     *
     * @var Zapier
     */
    use GetInstance;
    use Zapier;

    public $priority = 20;
    public $id       = 'zapier_conversions';
    public $img      = SURFALERT_ADMIN_URL . 'images/extensions/sources/zapier.png';
    public $doc_link = 'https://surfalert.com/docs/zapier-notification-alert/';
    public $types    = 'conversions';
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
                <span>A well-known web-based tool to connect with any of your web-based applications & boost productivity.</span>
                <iframe id="email_subscription_video" type="text/html" allowfullscreen width="450" height="235"
                src="https://www.youtube.com/embed/KjdLv5YMByQ">
                </iframe>
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
        <ul class="conversions sa-template-keys">
            <li><span>' . __('Field Name:', 'surfalert') . '</span> <strong>' . __('Field Key', 'surfalert') . '</strong></li>
            <li><span>' . __('Full Name:', 'surfalert') . '</span> <strong>name</strong></li>
            <li><span>' . __('First Name:', 'surfalert') . '</span> <strong>first_name</strong></li>
            <li><span>' . __('Last Name:', 'surfalert') . '</span> <strong>last_name</strong></li>
            <li><span>' . __('Sales Count:', 'surfalert') . '</span> <strong>sales_count</strong></li>
            <li><span>' . __('Customer Email:', 'surfalert') . '</span> <strong>email</strong></li>
            <li><span>' . __('Title, Product Title:', 'surfalert') . '</span> <strong>title</strong></li>
            <li><span>' . __('Anonymous Title, Product:', 'surfalert') . '</span> <strong>anonymous_title</strong></li>
            <li><span>' . __('Definite Time:', 'surfalert') . '</span> <strong>timestamp</strong></li>
            <li><span>' . __('Sometime:', 'surfalert') . '</span> <strong>sometime</strong></li>
            <li><span>' . __('In last 1 day:', 'surfalert') . '</span> <strong>1day</strong></li>
            <li><span>' . __('In last 7 days:', 'surfalert') . '</span> <strong>7days</strong></li>
            <li><span>' . __('In last 30 days:', 'surfalert') . '</span> <strong>30days</strong></li>
            <li><span>' . __('City:', 'surfalert') . '</span> <strong>city</strong></li>
            <li><span>' . __('Country:', 'surfalert') . '</span> <strong>country</strong></li>
            <li><span>' . __('City,Country:', 'surfalert') . '</span> <strong>city_country</strong></li>
        </ul>';
    }
}
