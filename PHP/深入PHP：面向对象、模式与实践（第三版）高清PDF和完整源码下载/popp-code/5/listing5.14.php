<?php
function __autoload( $classname ) {
    $path = str_replace('_', DIRECTORY_SEPARATOR, $classname );
    require_once( "$path.php" );
}

$x = new ShopProduct();
$y = new business_ShopProduct();
?>
