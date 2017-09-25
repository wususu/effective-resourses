<?php
namespace com\getinstance\util;
require_once 'global.php';
class Lister {
    public static function helloWorld() {
        print "hello from ".__NAMESPACE__."\n";
    }
}

Lister::helloWorld();  // access local
\Lister::helloWorld(); // access global
?>
