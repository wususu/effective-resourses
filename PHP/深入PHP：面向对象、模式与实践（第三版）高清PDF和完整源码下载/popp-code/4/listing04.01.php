<?php

class StaticExample {
    static public $aNum = 0;
    static public function sayHello() {
        print "hello";
    }
}

print StaticExample::$aNum;
StaticExample::sayHello();
?>
