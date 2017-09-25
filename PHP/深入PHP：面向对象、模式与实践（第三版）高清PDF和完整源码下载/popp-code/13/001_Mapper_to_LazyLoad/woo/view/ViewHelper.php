<?php
namespace woo\view;

//require_once( "woo/base/Registry.php" );

class VH {
    static function getRequest() {
        return \woo\base\RequestRegistry::getRequest();
    }
}

?>
