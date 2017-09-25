<?php

class StaticExample {
    static public $aNum = 0;
    static public function sayHello() {
        self::$aNum++;
        print "hello (".self::$aNum.")\n";
    }
}

StaticExample::sayHello();
StaticExample::sayHello();
StaticExample::sayHello();

?>
