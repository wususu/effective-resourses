<?php
require_once('userthing/persist/UserStore.php');
require_once('PHPUnit/Framework/TestCase.php');


class UserStoreTest extends PHPUnit_Framework_TestCase {
    private $store;

    public function setUp() {
        $this->store = new \userthing\persist\UserStore();
    }

    public function testAddUser_ShortPass() {
        $this->setExpectedException('Exception'); 
        $this->store->addUser(  "bob williams", "a@b.com", "ff" );
        $this->fail("Short password exception expected");
    }

    public function  testAddUser_duplicate() {
            try {
                $ret = $this->store->addUser(  "bob williams", "a@b.com", "123456" );
                $ret = $this->store->addUser(  "bob stevens", "a@b.com", "123456" );
                self::fail( "Exception should have been thrown" );
            } catch ( Exception $e ) {
                $const = $this->logicalAnd(
                            $this->isType('object') 
                        );
                self::AssertThat( $this->store->getUser( "a@b.com"), $const );
            }
    }

    public function  testGetUser() {
        $this->store->addUser(  "bob williams", "a@b.com", "12345" );
        $user = $this->store->getUser(  "a@b.com" );
        $this->assertEquals( $user->getMail(), "a@b.com" );
    }

}
?>
