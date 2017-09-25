<?php

function __autoload( $classname ) {
    include_once( "$classname.php" );
}
$product = new ShopProduct( 'The Darkening', 'Harry', 'Hunter', 12.99 );
?>
