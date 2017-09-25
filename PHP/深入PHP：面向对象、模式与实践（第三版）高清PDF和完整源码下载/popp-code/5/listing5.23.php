<?php

class OtherShop {
    function thing() {
        print "thing\n";
    }
    function andAnotherthing( $a, $b ) {
        print "another thing ($a, $b)\n";
    }
}

class Delegator {
    private $thirdpartyShop;
    function __construct() {
        $this->thirdpartyShop = new OtherShop();
    }

    function __call( $method, $args ) {
        if ( method_exists( $this->thirdpartyShop, $method ) ) {
            return call_user_func_array(
                        array( $this->thirdpartyShop,
                            $method ), $args );
        }
    }
}

$d = new Delegator();
$d->andAnotherThing( "a", "b" );

?>
