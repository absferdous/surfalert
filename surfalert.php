<?php
/**
 * Plugin Name:       SurfAlert
 * Plugin URI:        https://surfalert.com
 * Description:       Social Proof & Recent Sales Popup, Comment Notification, Subscription Notification, Notification Bar and many more.
 * Version:           3.1.3
 * Author:            WPDeveloper
 * Author URI:        https://wpdeveloper.com
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       surfalert
 * Domain Path:       /languages
 *
 * @package           SurfAlert
 * @link              https://wpdeveloper.com
 * @since             1.0.0
 */

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}
/**
 * Defines CONSTANTS for Whole plugins.
 */
define( 'SURFALERT_FILE', __FILE__ );
define( 'SURFALERT_VERSION', '3.1.3' );
define( 'SURFALERT_URL', plugins_url( '/', __FILE__ ) );
define( 'SURFALERT_PATH', plugin_dir_path( __FILE__ ) );
define( 'SURFALERT_BASENAME', plugin_basename( __FILE__ ) );

define( 'SURFALERT_ASSETS', SURFALERT_URL . 'assets/' );
define( 'SURFALERT_ASSETS_PATH', SURFALERT_PATH . 'assets/' );
define( 'SURFALERT_DEV_ASSETS', SURFALERT_URL . 'nxbuild/' );
define( 'SURFALERT_DEV_ASSETS_PATH', SURFALERT_PATH . 'nxbuild/' );
define( 'SURFALERT_INCLUDES', SURFALERT_PATH . 'includes/' );


define( 'SURFALERT_PLUGIN_URL', 'https://surfalert.com' );
define( 'SURFALERT_ADMIN_URL', SURFALERT_ASSETS . 'admin/' );
define( 'SURFALERT_PUBLIC_URL', SURFALERT_ASSETS . 'public/' );
define( 'SURFALERT_COMMON_URL', SURFALERT_ASSETS . 'common/' );

/**
 * The Core Engine of the Plugin
 */
if ( ! class_exists( '\SurfAlert\SurfAlert' ) ) {
    require_once SURFALERT_PATH . 'vendor/autoload.php';
    if ( sa_is_plugin_active( 'surfalert-pro/surfalert-pro.php' ) ) {
        add_action( 'admin_notices', 'sa_free_compatibility_notice' );
        if ( file_exists( dirname( SURFALERT_PATH ) . '/surfalert-pro/surfalert-pro.php' ) ) {
            require_once dirname( SURFALERT_PATH ) . '/surfalert-pro/surfalert-pro.php';
        } else {
            add_action('plugins_loaded', function() {
                remove_action( 'admin_notices', 'surfalert_install_core_notice' );
                \SurfAlert\Core\Helper::remove_old_notice();
            });
        }
    }

    function activate_surfalert() {
        \SurfAlert\SurfAlert::get_instance()->activator();
    }
    /**
     * Plugin Activator
     */
    register_activation_hook( SURFALERT_FILE, 'activate_surfalert' );
    \SurfAlert\SurfAlert::get_instance();
}

function sa_free_compatibility_notice() {
    if ( ! function_exists( 'get_plugins' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();
    if ( isset( $plugins['surfalert-pro/surfalert-pro.php']['Version'] ) && version_compare( $plugins['surfalert-pro/surfalert-pro.php']['Version'], '2.5.0', '>=' ) ) {
        return;
    }
    ?>
        <div class="notice notice-warning is-dismissible">
            <p>
            <?php echo sprintf( __( "<strong>Recommended: </strong> Seems like you haven't updated the SurfAlert Pro version. Please make sure to update SurfAlert Pro plugin from <a href='%s'><strong>wp-admin -> Plugins</strong></a>.", 'surfalert' ), esc_url( admin_url( 'plugins.php' ) ) ); ?></p>
        </div>
    <?php
}


function sa_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) || sa_is_plugin_active_for_network( $plugin );
}

function sa_is_plugin_active_for_network( $plugin ) {
    if ( ! is_multisite() ) {
        return false;
    }

    $plugins = get_site_option( 'active_sitewide_plugins' );
    if ( isset( $plugins[ $plugin ] ) ) {
        return true;
    }

    return false;
}

//declare compliance with WP Consent API
add_filter( "wp_consent_api_registered_".SURFALERT_BASENAME, '__return_true' );