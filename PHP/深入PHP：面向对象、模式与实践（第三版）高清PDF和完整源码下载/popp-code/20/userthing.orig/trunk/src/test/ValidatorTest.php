<?php
require_once('userthing/persist/UserStore.php');
require_once('userthing/util/Validator.php');
require_once('PHPUnit/Framework/TestCase.php');


class ValidatorTest extends PHPUnit_Framework_TestCase {
    private $validator;

    public function setUp() {
        $store = new \userthing\persist\UserStore();
        $store->addUser(  "bob williams", "bob@example.com", "12345" );
        $this->validator = new \userthing\util\Validator( $store );
    }
    public function tearDown() {
    }

    public function testValidate_CorrectPass() {
        $this->assertTrue(
            $this->validator->validateUser( "bob@example.com", "12345" ),
            "Expecting successful validation"
            );
    }

    public function testValidate_FalsePass() {
        $store = $this->getMock("\\userthing\\persist\\UserStore");
        $this->validator = new \userthing\util\Validator( $store );

        $store->expects($this->once() )
              ->method('notifyPasswordFailure')
              ->with( $this->equalTo('bob@example.com') );

        $store->expects( $this->any() )
              ->method("getUser")
              ->will( $this->returnValue(new \userthing\domain\User( "bob williams", "bob@example.com", "right")));

        $this->validator->validateUser("bob@example.com", "wrong"); 
    } 
}
?>
