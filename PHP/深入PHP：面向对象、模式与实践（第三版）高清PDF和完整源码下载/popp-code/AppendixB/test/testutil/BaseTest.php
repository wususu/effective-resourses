<?php
require_once "PHPUnit/Framework/TestCase.php";
require_once "test/testutil/SuiteWrapper.php";

abstract class test_testutil_BaseTest extends 
PHPUnit_Framework_TestCase {
     
    public function say( $thing ) { 
        $sayit = ($GLOBALS['_ENV']['UNITSAY'])?
                true:testutil_SuiteWrapper::verbose();
        if ( $sayit ) {
            print "\n### $thing\n";
        }
    }
}
