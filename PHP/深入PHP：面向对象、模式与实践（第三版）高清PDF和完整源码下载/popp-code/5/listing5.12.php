<?php
namespace {
    class Lister {
        public static function helloWorld() {
            print "hello from global\n";
        }
    }
}
namespace com\getinstance\util {
    class Lister {
        public static function helloWorld() {
            print "hello from ".__NAMESPACE__."\n";
        }
    }

    Lister::helloWorld();  // access local
    \Lister::helloWorld(); // access global
}
?>
