<?php
require_once 'PHPUnit/Framework.php';
require_once 'test/UserStoreTest.php';
require_once 'test/ValidatorTest.php';
 
class UserTests
{
    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite();
        $suite->addTestSuite('UserStoreTest');
        $suite->addTestSuite('ValidatorTest');
 
        return $suite;
    }
}
?>
