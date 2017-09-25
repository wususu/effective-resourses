<?php

class OtherShop {
    function thing() {
        print "thing\n";
    }
    function andAnotherthing() {
        print "another thing\n";
    }
}

class Delegator {
    private $thirdpartyShop;
    function __construct() {
        $this->thirdpartyShop = new OtherShop();
    }

    function __call( $method, $args ) {
        if ( method_exists( $this->thirdpartyShop, $method ) ) {
            return $this->thirdpartyShop->$method( );
        }
    }
}

$d = new Delegator();
$d->thing();

?>
