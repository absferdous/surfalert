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
 * @method static ZapierEmailSubscription get_instance($args = null)
 */
class ZapierEmailSubscription extends Extension {
    /**
     * Instance of Zapier
     *
     * @var Zapier
     */
    use GetInstance;
    use Zapier;

    public $priority = 15;
    public $id       = 'zapier_email_subscription';
    public $img      = SURFALERT_ADMIN_URL . 'images/extensions/sources/zapier.png';
    public $doc_link = 'https://surfalert.com/docs/zapier-notification-alert/';
    public $types    = 'email_subscription';
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
        <ul class="email_subscription sa-template-keys">
            <li><span>' . __('Field Name:', 'surfalert') . '</span> <strong>' . __('Field Key', 'surfalert') . '</strong></li>
            <li><span>' . __('Full Name:', 'surfalert') . '</span> <strong>name</strong></li>
            <li><span>' . __('First Name:', 'surfalert') . '</span> <strong>first_name</strong></li>
            <li><span>' . __('Last Name:', 'surfalert') . '</span> <strong>last_name</strong></li>
            <li><span>' . __('Email:', 'surfalert') . '</span> <strong>email</strong></li>
            <li><span>' . __('Title, Product Title:', 'surfalert') . '</span> <strong>title</strong></li>
            <li><span>' . __('Anonymous Title:', 'surfalert') . '</span> <strong>anonymous_title</strong></li>
            <li><span>' . __('Definite Time:', 'surfalert') . '</span> <strong>timestamp</strong></li>
            <li><span>' . __('Some time ago:', 'surfalert') . '</span> <strong>sometime</strong></li>
            <li><span>' . __('City:', 'surfalert') . '</span> <strong>city</strong></li>
            <li><span>' . __('Country:', 'surfalert') . '</span> <strong>country</strong></li>
            <li><span>' . __('City,Country:', 'surfalert') . '</span> <strong>city_country</strong></li>
        </ul>';
    }
}
