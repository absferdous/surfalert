<?php
namespace SurfAlert\ThirdParty;

use SurfAlert\GetInstance;

/**
 * Visual Portfolio, Posts & Image Gallery
 * Stop showing notification if visual portfolio preview is active.
 *
 * https://wordpress.org/plugins/visual-portfolio/
 */
class VisualPortfolio {
    use GetInstance;

    public function __construct() {
        add_filter( 'sa_before_enqueue_scripts', array( $this, 'sa_before_enqueue_scripts' ) );
    }

    public function sa_before_enqueue_scripts($result) {
        if(!empty($_GET['vp_preview'])){
            return ['total' => 0];
        }

        return $result;
    }
}
