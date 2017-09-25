<?php
require_once( "closures.php" );

$logger2 = function( $product ) {
   print "    logging ({$product->name})\n";
};

$processor = new ProcessSale();
$processor->registerCallback( $logger2 );

$processor->sale( new Product( "shoes", 6 ) );
print "\n";
$processor->sale( new Product( "coffee", 6 ) );
?>
