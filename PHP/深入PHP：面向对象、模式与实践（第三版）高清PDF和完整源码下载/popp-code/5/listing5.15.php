<?php

namespace business {
//$a = new \business\ShopProduct3();
$a = new ShopProduct3();
}
namespace pants {
    use business\ShopProduct2 as tweetiepie;
    $a = new tweetiepie();
}

namespace {
function __autoload( $classname ) {
    //print "classname: $classname\n";
    if ( preg_match( '/\\\\/', $classname ) ) {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $classname );
    } else {
        $path = str_replace('_', DIRECTORY_SEPARATOR, $classname );
    }
    //print "path: $path\n";
    require_once( "$path.php" );
}

//$x = new ShopProduct();
$y = new business_ShopProduct();
//$z = new business\ShopProduct2();
//$a = new \business\ShopProduct3();
}
?>
