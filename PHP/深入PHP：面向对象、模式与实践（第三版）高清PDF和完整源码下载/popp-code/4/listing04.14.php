<?php
require_once( "closures.php" );

$logger = create_function( '$product', 
                           'print "    logging ({$product->name})\n";' );

$processor = new ProcessSale();
$processor->registerCallback( $logger );

$processor->sale( new Product( "shoes", 6 ) );
print "\n";
$processor->sale( new Product( "coffee", 6 ) );
?>
