<?php
require_once( "closures.php" );

class Totalizer {
    static function warnAmount() {
        return function( $product ) {
            if ( $product->price > 5 ) {
                print "    reached high price: {$product->price}\n";
            }
        };
    }
}

$processor = new ProcessSale();
$processor->registerCallback( Totalizer::warnAmount() );

$processor->sale( new Product( "shoes", 6 ) );
print "\n";
$processor->sale( new Product( "coffee", 6 ) );
?>
