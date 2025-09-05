<?php
/**
 * IFTTT Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\IFTTT;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * IFTTT Extension
 * @method static IFTTT get_instance($args = null)
 */
class IFTTT extends Extension {
    /**
     * Instance of IFTTT
     *
     * @var IFTTT
     */
    use GetInstance;

    public $id = 'ifttt';
    public $img = '';
    public $doc_link = 'https://surfalert.com/docs/ifttt-notification-alert/';
    public $types = 'email_subscription';
    public $module = 'modules_ifttt';
    public $is_pro = true;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('IFTTT', 'surfalert');
        $this->module_title = __('IFTTT', 'surfalert');
    }

    /**
     * Get data for IFTTT Extension.
     *
     * @param array $args Settings arguments.
     * @return array
     */
    public function get_data( $args = array() ){
        return 'Hello From IFTTT';
    }
}
