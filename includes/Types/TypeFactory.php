<?php
/**
 * Type Factory
 *
 * @package SurfAlert\Types
 */

namespace SurfAlert\Types;
use SurfAlert\GetInstance;

/**
 * TypeFactory Class
 * @method static TypeFactory get_instance($args = null)
 */
class TypeFactory {
    /**
     * Instance of Admin
     *
     * @var Admin
     */
	use GetInstance;

	public $types = [
            'conversions'        => 'SurfAlert\Types\Conversions',
            'woocommerce_sales'  => 'SurfAlert\Types\WooCommerceSales',
            'comments'           => 'SurfAlert\Types\Comments',
            'reviews'            => 'SurfAlert\Types\Reviews',
            'download_stats'     => 'SurfAlert\Types\DownloadStats',
            'elearning'          => 'SurfAlert\Types\ELearning',
            'donation'           => 'SurfAlert\Types\Donations',
            'notification_bar'   => 'SurfAlert\Types\NotificationBar',
            'form'               => 'SurfAlert\Types\ContactForm',
            'email_subscription' => 'SurfAlert\Types\EmailSubscription',
            'page_analytics'     => 'SurfAlert\Types\PageAnalytics',
            'custom'             => 'SurfAlert\Types\CustomNotification',
            'inline'             => 'SurfAlert\Types\Inline',
            'flashing_tab'       => 'SurfAlert\Types\FlashingTab',
            'video'              => 'SurfAlert\Types\Video',
            'offer_announcement' => 'SurfAlert\Types\OfferAnnouncement',
            'gdpr'               => 'SurfAlert\Types\GDPR',
		];

    public $types_enabled = [];

	/**
	 * Initially Invoked when initialized.
	 */
	public function __construct(){
		$this->types = apply_filters( 'sa_types_classes', $this->types );

	}

    /**
     * Registers a type.
     *
     * @param string $id
     * @return mixed
     */
	public function register_types($id){
		if(!isset($this->types_enabled[$id]) && isset($this->types[$id])){
            $type_class = $this->types[$id];
			$obj = $type_class::get_instance();
			return $this->add($obj);
		}
		return false;
	}

    /**
     * Enable a type.
     *
     * @param Type $types
     * @return Type
     */
    protected function add( $type) {
		$this->types_enabled[ $type->id ] = $type;
		return $type;
	}

    /**
     * This function is responsible for getting the type from loaded type.
     *
     * @param string $key
     * @return Types
     */
    public function get( $key ){
        if( empty( $key ) ) {
            return false;
        }
        if(isset($this->types_enabled[$key])){
            return isset( $this->types_enabled[ $key ] ) ? $this->types_enabled[ $key ] : false;
        }
        else if(isset( $this->types[ $key ] ) && $type_class = $this->types[ $key ]){
            return $type_class::get_instance();
        }
    }

    /**
     * Get all enabled types.
     *
     * @return array
     */
    public function get_all(){
        return $this->types_enabled;
    }
}
