<?php
/**
 * Wistia Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\Wistia;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * Wistia Extension
 * @method static Wistia get_instance($args = null)
 */
class Wistia extends Extension {
    /**
     * Instance of Wistia
     *
     * @var Wistia
     */
    use GetInstance;

    public $priority        = 15;
    public $id              = 'wistia';
    public $doc_link        = 'https://surfalert.com/docs/google-reviews-with-surfalert/';
    public $types           = 'video';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/wistia.png';
    public $show_on_module  = false;
    public $show_on_type     = false;
    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }
    
    public function init_extension()
    {
        $this->title = __('Wistia', 'surfalert');
    }

}
