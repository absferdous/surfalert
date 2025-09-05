<?php

namespace SurfAlert\Core;

use SurfAlert\Admin\Admin;
use SurfAlert\GetInstance;

/**
 * @method static Dashboard get_instance($args = null)
 */
class Dashboard {

    /**
     * Instance of QuickBuild
     *
     * @var QuickBuild
     */
    use GetInstance;

    /**
     * Initially Invoked when initialized.
     *
     * @hook init
    */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'menu' ], 30 );
    }

    /**
     * This method is responsible for Admin Menu of
     * SurfAlert
     *
     * @return void
     */
    public function menu() {
        add_submenu_page( 'sa-admin', __( 'Dashboard', 'surfalert' ), __( 'Dashboard', 'surfalert' ), 'read_surfalert', 'sa-dashboard', [ Admin::get_instance(), 'views' ], 0 );
    }

}
