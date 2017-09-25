<?php
if ( ! defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'testutil_SuiteWrapper::main');
}
require_once 'PHPUnit/TextUI/TestRunner.php';
require_once "PHPUnit/Framework/TestSuite.php";

class test_testutil_SuiteWrapper {
    private static $instance;
    private $suite;
    private $verbose = false;
    private $autorun = true;

    static function main() {
        PHPUnit_TextUI_TestRunner::run(self::instance()->suite);
    }

    public function __destruct() {
        if ( $this->autorun ) {
            PHPUnit_TextUI_TestRunner::run($this->suite);
        }
    }

    private function __construct() { 
        $this->suite = new PHPUnit_Framework_TestSuite();
    }

    private static function instance() {
        if ( ! self::$instance ) self::$instance = new self();
        return self::$instance;
    } 

    public static function verbose( ) {
        return self::instance()->verbose;
    }

    public static function setVerbose( $bool ) {
        self::instance()->verbose = $bool;
    }   

    public static function autorun( $bool ) {
        return self::instance()->autorun = $bool;
    }

    public static function addTestCase( $package ) {
        self::instance()->suite->addTest(
            new PHPUnit_Framework_TestSuite( $package ) 
        );
    }
}

?>
