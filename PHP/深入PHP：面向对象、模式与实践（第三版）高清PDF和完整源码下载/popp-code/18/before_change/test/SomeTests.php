<?php
if (! defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'SomeTests::main');
}

require_once( "PHPUnit/Framework/TestSuite.php" );
require_once( "PHPUnit/TextUI/TestRunner.php" );
require_once( "UserStoreTest.php" );
require_once( "ValidatorTest.php" );


class SomeTests {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run( self::suite() );
    }

    public static function suite() {
        $ts = new PHPUnit_Framework_TestSuite( 'User Classes');
        $ts->addTestSuite('UserStoreTest');
        $ts->addTestSuite('ValidatorTest');
        return $ts;
    }
}

if (PHPUnit_MAIN_METHOD == 'SomeTests::main') {
    SomeTests::main();
}
?>
