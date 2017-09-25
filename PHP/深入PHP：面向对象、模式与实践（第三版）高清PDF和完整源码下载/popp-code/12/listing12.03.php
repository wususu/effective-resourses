<?php

class Registry {
    private static $instance;
    private $request;
    private $treeBuilder;
    private static $testmode=false;

    private function __construct() { }

    static function testMode( $mode=true ) {
        self::$instance=null;
        self::$testmode=$mode;
    }

    static function instance() {
        if ( self::$testmode ) {
            return new MockRegistry();
        }
        if ( ! isset( self::$instance ) ) { self::$instance = new self(); }
        return self::$instance;
    }

    function getRequest() {
        return $this->request;
    }

    function setRequest( Request $request ) {
        $this->request = $request;
    }

    function treeBuilder() {
        if ( ! isset( $this->treeBuilder ) ) {
            $this->treeBuilder = new TreeBuilder( $this->conf()->get('treedir') ); 
        }
        return $this->treeBuilder;
    }
    
    function conf() {
        if ( ! isset( $this->conf ) ) {
            $this->conf = new Conf();
        }
        return $this->conf;
    }
}

class Conf {
    function get() {
    }
}

class TreeBuilder {
}

class MockRegistry {

}

// empty class for testing
class Request {}
$reg = Registry::instance();
$reg->setRequest( new Request() );
$reg2 = Registry::instance();
print_r( $reg2->getRequest() );
print_r( $reg2->treeBuilder() );

// testing the system
Registry::testMode();
$mockreg = Registry::instance();


print_r( $mockreg );
Registry::testMode( false );
$reg4 = Registry::instance();
print_r( $reg4 );
?>
