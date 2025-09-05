<?php
/**
 * Freemius Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\Freemius;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * Freemius Extension
 * @method static FreemiusConversions get_instance($args = null)
 */
class FreemiusConversions extends Extension {
    /**
     * Instance of Freemius
     *
     * @var Freemius
     */
    use GetInstance;
    use Freemius;

    public $priority = 15;
    public $id       = 'freemius_conversions';
    public $types    = 'conversions';
    public $img      = SURFALERT_ADMIN_URL . 'images/extensions/sources/freemius.png';
    public $doc_link = 'https://surfalert.com/docs/freemius-sales-notification/';
    public $module   = 'modules_freemius';
    public $is_pro   = true;
    public $module_priority = 12;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('Freemius', 'surfalert');
        $this->module_title = __('Freemius', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/freemius-sales-notification/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>Fantastic platform for WordPress users to sell their items all around the world.</span>
                <iframe id="email_subscription_video" type="text/html" allowfullscreen width="450" height="235"
                src="https://www.youtube.com/embed/0uANsOSFmtw">
                </iframe>
            ', 'surfalert')
        ];
    }
}
