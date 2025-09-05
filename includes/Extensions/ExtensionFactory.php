<?php
/**
 * Extension Factory
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions;

use Exception;
use SurfAlert\Core\Database;
use SurfAlert\GetInstance;
use SurfAlert\Core\Modules;

/**
 * ExtensionFactory Class
 *
 * @method static ExtensionFactory get_instance($args = null)
 */
class ExtensionFactory {
    /**
     * Instance of Admin
     *
     * @var Admin
     */
	use GetInstance;

	public $active_items;
	public $types = [];
	public $extensions = [];
	public $extension_classes = [
			'woo_inline'                      => 'SurfAlert\Extensions\WooCommerce\WooInline',
			'edd_inline'                      => 'SurfAlert\Extensions\EDD\EDDInline',
			'tutor_inline'                    => 'SurfAlert\Extensions\Tutor\TutorInline',
			'learndash_inline'                => 'SurfAlert\Extensions\LearnDash\LearnDashInline',
			'learnpress_inline'               => 'SurfAlert\Extensions\LearnPress\LearnPressInline',
			'cf7'                             => 'SurfAlert\Extensions\CF7\CF7',
			'convertkit'                      => 'SurfAlert\Extensions\ConvertKit\ConvertKit',
			'custom_notification'             => 'SurfAlert\Extensions\CustomNotification\CustomNotification',
			'custom_notification_conversions' => 'SurfAlert\Extensions\CustomNotification\CustomNotificationConversions',
			'announcements'                   => 'SurfAlert\Extensions\OfferAnnouncement\Announcements',
			'edd'                             => 'SurfAlert\Extensions\EDD\EDD',
			'envato'                          => 'SurfAlert\Extensions\Envato\Envato',
			'freemius_conversions'            => 'SurfAlert\Extensions\Freemius\FreemiusConversions',
			'freemius_reviews'                => 'SurfAlert\Extensions\Freemius\FreemiusReviews',
			'freemius_stats'                  => 'SurfAlert\Extensions\Freemius\FreemiusStats',
			'grvf'                            => 'SurfAlert\Extensions\GRVF\GravityForms',
			'give'                            => 'SurfAlert\Extensions\Give\Give',
			'google'                          => 'SurfAlert\Extensions\Google_Analytics\Google_Analytics',
			'google_reviews'                  => 'SurfAlert\Extensions\Google\GoogleReviews',
			'learndash'                       => 'SurfAlert\Extensions\LearnDash\LearnDash',
			'learnpress'                      => 'SurfAlert\Extensions\LearnPress\LearnPress',
			'mailchimp'                       => 'SurfAlert\Extensions\MailChimp\MailChimp',
			'njf'                             => 'SurfAlert\Extensions\NJF\NinjaForms',
			'press_bar'                       => 'SurfAlert\Extensions\PressBar\PressBar',
			'tutor'                           => 'SurfAlert\Extensions\Tutor\Tutor',
			'wpf'                             => 'SurfAlert\Extensions\WPF\WPForms',
			'reviewx'                         => 'SurfAlert\Extensions\ReviewX\ReviewX',
			'woocommerce'                     => 'SurfAlert\Extensions\WooCommerce\WooCommerce',
			'woocommerce_sales'               => 'SurfAlert\Extensions\WooCommerce\WooCommerceSales',
			'woocommerce_sales_reviews'       => 'SurfAlert\Extensions\WooCommerce\WooCommerceSalesReviews',
			'woocommerce_sales_inline'       => 'SurfAlert\Extensions\WooCommerce\WooCommerceSalesInline',
			'woo_reviews'                     => 'SurfAlert\Extensions\WooCommerce\WooReviews',
			'wp_comments'                     => 'SurfAlert\Extensions\WordPress\WPComments',
			'wp_reviews'                      => 'SurfAlert\Extensions\WordPress\WPOrgReview',
			'wp_stats'                        => 'SurfAlert\Extensions\WordPress\WPOrgStats',
			'zapier_conversions'              => 'SurfAlert\Extensions\Zapier\ZapierConversions',
			'zapier_email_subscription'       => 'SurfAlert\Extensions\Zapier\ZapierEmailSubscription',
			'zapier_reviews'                  => 'SurfAlert\Extensions\Zapier\ZapierReviews',
			'elementor_form'                  => 'SurfAlert\Extensions\Elementor\From',
			'flashing_tab'                    => 'SurfAlert\Extensions\FlashingTab\FlashingTab',
			'fluentform'                      => 'SurfAlert\Extensions\FluentForm\FluentForm',
			'youtube'                         => 'SurfAlert\Extensions\Google\YouTube',
			'vimeo'                           => 'SurfAlert\Extensions\Vimeo\Vimeo',
			'wistia'                          => 'SurfAlert\Extensions\Wistia\Wistia',
			'surecart'                        => 'SurfAlert\Extensions\SureCart\SureCart',
			'ActiveCampaign'				  => 'SurfAlert\Extensions\ActiveCampaign\ActiveCampaign',
			'gdpr_notification'				  => 'SurfAlert\Extensions\GDPR\GDPR_Notification',
			'ccpa_notification'				  => 'SurfAlert\Extensions\CCPA\CCPA_Notification',
		];

	/**
	 * Initially Invoked when initialized.
	 */
	public function __construct(){
		// GlobalFields::get_instance();
		$this->register_extensions();
	}

	public function register_extensions(){
		$this->extension_classes = apply_filters( 'sa_extension_classes', $this->extension_classes );
		foreach ($this->extension_classes as $extension) {
			// initializing extension.
			if(class_exists($extension)){
				$obj = $extension::get_instance();
				if(Modules::get_instance()->is_enabled($obj->module)){
					$this->add($obj);
				}
			}
		}
	}

	/**
     * This function is responsible for adding an extension to the extensions array!
     *
     * @param array $extensions
     * @param string $classname
     * @return void
     */
    protected function add( $extension) {
		$this->extensions[ $extension->id ] = $extension;
		$this->types[$extension->types][ $extension->id ] = $extension;
		return $this->extensions;
	}

	/**
	 * Get Extensions data
	 *
	 * @param Extension $extension The notifications type.
	 * @param array     $args Settings arguments for surfalert.
	 * @return array
	 */
	public static function getExtension( Extension $extension, $args = array() ){
		return $extension->get_data( $args );
	}

    /**
     * This function is responsible for getting the extension from loaded extension.
     *
     * @param string $key
     * @return Extension
     */
    public function get( $key ){
        if( empty( $key ) ) {
            return false;
        }
		try {
			$class = $this->extension_classes[$key];
			if(class_exists($class)){
				return $class::get_instance();
			}
		}
		catch (\Exception $e) {

		}
        return isset( $this->extensions[ $key ] ) ? $this->extensions[ $key ] : false;
	}

    /**
     * This function is responsible for getting the extension from loaded extension.
     *
     * @param string $key
     * @return array|bool
     */
    public function get_type( $type ){
        if( empty( $type ) ) {
            return false;
        }
        return isset( $this->types[ $type ] ) ? $this->types[ $type ] : false;
	}

    /**
     * This function is responsible for getting the extension from loaded extension.
     *
     * @param string $key
     * @return array
     */
    public function get_themes_for_type( $type ){
		$themes = [];

		$extensions = $this->get_type($type);

		if(is_array($extensions)){
			foreach($extensions as $extension){
				if(!$extension->exclude_custom_themes){
					$themes = array_merge($themes, $extension->get_themes_name());
				}
			}
		}

		return array_unique($themes);
	}

    /**
     * This function is responsible for getting the extension from loaded extension.
     *
     * @param string $key
     * @return bool|void
     */
    public function get_all(){
        return $this->extensions;
    }
}
