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
 * FreemiusReviews Extension
 * @method static FreemiusReviews get_instance($args = null)
 */
class FreemiusReviews extends Extension {
    /**
     * Instance of Freemius
     *
     * @var Freemius
     */
    use GetInstance;
    use Freemius;

    public $priority = 20;
    public $id       = 'freemius_reviews';
    public $types    = 'reviews';
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
            "denyButtonText" => __("<a href='https://surfalert.com/docs/freemius-review-surfalert/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>Widely used medium to show review teasers to persuade visitors to trust your offerings.</span>
            ', 'surfalert')
        ];
    }

}
