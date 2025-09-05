<?php

namespace SurfAlert\Core;

use SurfAlert\Admin\Entries;
use SurfAlert\Admin\Settings;
use SurfAlert\Core\Database;
use SurfAlert\GetInstance;


/**
 * @method static Limiter get_instance($args = null)
 */
class Limiter {
    use GetInstance;

    /**
     * Initial Invoked
     */
    public function __construct() {
    }

    public function remove($sa_id, $new) {
        $count = Entries::get_instance()->count($sa_id, 'sa_id');
        $limit = Settings::get_instance()->get('settings.cache_limit', 100);
        if ($limit <= 0) {
            $limit = 100;
        }

        if ($new + $count > $limit) {
            $overflow = ($new + $count) - $limit;
            Entries::get_instance()->delete_entries($sa_id, $overflow);
        }
    }
}
