<?php
require_once( "closures.php" );

class Mailer {
    function doMail( $product ) {
        print "    mailing ({$product->name})\n";
    }
}

$processor = new ProcessSale();
$processor->registerCallback( array( new Mailer(), "doMail" ) );

$processor->sale( new Product( "shoes", 6 ) );
print "\n";
$processor->sale( new Product( "coffee", 6 ) );
?>
