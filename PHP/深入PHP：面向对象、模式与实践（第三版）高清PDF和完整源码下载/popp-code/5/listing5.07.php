<?php

namespace com\getinstance\util;

class Debug {
    static function helloWorld() {
        print "hello from Debug\n";
    }
}

namespace main;
use com\getinstance\util\Debug;
Debug::helloWorld();
?>
