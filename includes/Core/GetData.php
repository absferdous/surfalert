<?php
/**
 * Extension Factory
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Core;

use SurfAlert\Admin\Settings;
use SurfAlert\GetInstance;

/**
 * GetData Class
 */
class GetData extends \ArrayObject {

    public function __get($name) {
        if ($this->offsetExists($name)) {
            return $this->offsetGet($name);
        }
        trigger_error('Undefined property: ' . $name);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet ($name){
        if(parent::offsetExists($name)){
            return parent::offsetGet($name);
        }
    }

}
