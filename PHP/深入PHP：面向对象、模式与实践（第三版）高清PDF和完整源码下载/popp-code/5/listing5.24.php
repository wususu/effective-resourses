<?php

require_once "fullshop.php";
$prod_class = new ReflectionClass( 'CdProduct' );
Reflection::export( $prod_class );

?>
