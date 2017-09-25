<?php

class Registry {
    private static $instance;
    private $values = array();

    private function __construct() { }

    static function instance() {
        if ( ! isset( self::$instance ) ) { self::$instance = new self(); }
        return self::$instance;
    }

    function get( $key ) {
        if ( isset( $this->values[$key] ) ) {
            return $this->values[$key];
        }
        return null;
    }

    function set( $key, $value ) {
        $this->values[$key] = $value;
    }
}

// empty class for testing
class Request {}

$reg = Registry::instance();
$reg->set( 'request', new Request() );

$reg = Registry::instance();
print_r( $reg->get( 'request' ) );

?>
