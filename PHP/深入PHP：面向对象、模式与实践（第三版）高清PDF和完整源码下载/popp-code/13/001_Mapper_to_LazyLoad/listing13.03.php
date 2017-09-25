<?php
require_once( "woo/domain/HelperFactory.php" );
$collection = \woo\domain\HelperFactory::getCollection("woo\\domain\\Venue");
$collection->add( new \woo\domain\Venue( null, "Loud and Thumping" ) );
$collection->add( new \woo\domain\Venue( null, "Eeezy" ) );
$collection->add( new \woo\domain\Venue( null, "Duck and Badger" ) );

foreach( $collection as $venue ) {
    print $venue->getName()."\n";
}
?>
