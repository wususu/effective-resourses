<?php
require_once('UserStore.php');
require_once('Validator.php');
require_once('PHPUnit/Framework/TestCase.php');


class ValidatorTest extends PHPUnit_Framework_TestCase {
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

    public function testValidate_FalsePass() {
        $store = $this->getMock("UserStore");
        $this->validator = new Validator( $store );

        $store->expects($this->once() )
              ->method('notifyPasswordFailure')
              ->with( $this->equalTo('bob@example.com') );

        $store->expects( $this->any() )
              ->method("getUser")
              ->will( $this->returnValue(new User( "bob williams", "bob@example.com", "right")));

        $this->validator->validateUser("bob@example.com", "wrong"); 

/*
        $store = $this->getMock("UserStore");
        $store->expects( $this->once() )
              ->method('notifyPasswordFailure');
        //$store->expects( $this->at( 1 ) ) // raise bug
        $store->expects( $this->once( ) )
              ->method("getUser")
              ->with( $this->equalTo('henry') );
*/
        //$store->getUser("bob@bob.com");
    } 
}
?>
