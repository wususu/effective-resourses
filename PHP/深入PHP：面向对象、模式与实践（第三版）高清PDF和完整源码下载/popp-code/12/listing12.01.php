<?php

class Registry {
    private static $instance;
    private $request;

    private function __construct() { }

    static function instance() {
        if ( ! isset( self::$instance ) ) { self::$instance = new self(); }
        return self::$instance;
    }

    function getRequest() {
        return $this->request;
    }

    function setRequest( Request $request ) {
        $this->request = $request;
    }
}
// empty class for testing
class Request {}

$reg = Registry::instance();
$reg->setRequest( new Request() );

$reg = Registry::instance();
print_r( $reg->getRequest() );
?>
