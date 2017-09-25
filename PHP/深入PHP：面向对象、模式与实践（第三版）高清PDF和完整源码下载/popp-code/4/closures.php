<?php

class Product {
    public $name;
    public $price;
    function __construct( $name, $price ) {
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale {
    private $callbacks;

    function registerCallback( $callback ) {
        if ( ! is_callable( $callback ) ) {
            throw new Exception( "callback not callable" );
        }
        $this->callbacks[] = $callback;
    }

    function sale( $product ) {
        print "{$product->name}: processing \n";
        foreach ( $this->callbacks as $callback ) {
            call_user_func( $callback, $product );
        }
    }
}
?>
