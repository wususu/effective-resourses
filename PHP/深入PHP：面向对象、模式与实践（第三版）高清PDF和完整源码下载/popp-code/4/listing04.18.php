<?php
require_once( "closures.php" );

class Totalizer {
    static function warnAmount( $amt ) {
        $count=0;
        return function( $product ) use ( $amt, &$count ) {
            $count += $product->price;
            print "   count: $count\n";
            if ( $count > $amt ) {
                print "   high price reached: {$count}\n";
            }
        };
    }
}

$processor = new ProcessSale();
$processor->registerCallback( Totalizer::warnAmount( 8) );

$processor->sale( new Product( "shoes", 6 ) );
print "\n";
$processor->sale( new Product( "coffee", 6 ) );
?>
