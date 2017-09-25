<?php
class ShopProduct {}
interface incidental {};

class CdProduct extends ShopProduct implements incidental {
    public $coverUrl;
    function __construct() { }
    function getPlayLength() { }
    function getSummaryLine() { }
    function getProducerFirstName() { }
    function getProducerMainName() { }
    function setDiscount() { }
    function getDiscount() { }
    function getTitle() { return "title\n"; }
    function getPrice() { }
    function getProducer() { }
}

function getProduct() {
    return new CdProduct();
}

$product = getProduct(); // acquire an object
$method = "getTitle";     // define a method name
print $product->$method();  // invoke the method
if ( in_array( $method, get_class_methods( $product ) ) ) {
    print $product->$method();  // invoke the method
}
if ( is_callable( array( $product, $method) ) ) {
    print $product->$method();  // invoke the method
}
if ( method_exists( $product, $method ) ) {
    print $product->$method();  // invoke the method
}
print_r( get_class_vars( 'CdProduct' ) );

if ( is_subclass_of( $product, 'ShopProduct' ) ) {
    print "CdProduct is a subclass of ShopProduct\n";
}

if ( is_subclass_of( $product, 'incidental' ) ) {
    print "CdProduct is a subclass of incidental\n";
}

if ( in_array( 'incidental', class_implements( $product )) ) {
    print "CdProduct is an interface of incidental\n";
}

?>
