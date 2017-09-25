<?php
require_once('UserStore.php');
require_once('Validator.php');
require_once('PHPUnit/Framework/TestCase.php');


class ValidatorTestBasic extends PHPUnit_Framework_TestCase {
    private $validator;

    public function setUp() {
        $store = new UserStore();
        $store->addUser(  "bob williams", "bob@example.com", "12345" );
        $this->validator = new Validator( $store );
    }

    public function tearDown() {
    }

    public function testValidate_CorrectPass() {
        $this->assertTrue(
            $this->validator->validateUser( "bob@example.com", "12345" ),
            "Expecting successful validation"
            );
    }
}
?>
