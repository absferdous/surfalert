<?php
/**
 * Vimeo Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\Vimeo;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * Vimeo Extension
 * @method static Vimeo get_instance($args = null)
 */
class Vimeo extends Extension {
    /**
     * Instance of Vimeo
     *
     * @var Vimeo
     */
    use GetInstance;

    public $priority        = 10;
    public $id              = 'vimeo';
    public $doc_link        = 'https://surfalert.com/docs/google-reviews-with-surfalert/';
    public $types           = 'video';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/vimeo.png';
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
        $this->title = __('Vimeo', 'surfalert');
    }

}
