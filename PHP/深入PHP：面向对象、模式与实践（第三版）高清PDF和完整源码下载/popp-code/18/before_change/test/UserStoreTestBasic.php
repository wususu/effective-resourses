<?php
require_once('UserStore.php');
require_once('PHPUnit/Framework/TestCase.php');


class UserStoreTest extends PHPUnit_Framework_TestCase {
    private $store;

    public function setUp() {
        $this->store = new UserStore();
    }

    public function tearDown() {
    }

    public function  testGetUser() {
        $this->store->addUser(  "bob williams", "a@b.com", "12345" );
        $user = $this->store->getUser(  "a@b.com" );
        $this->assertEquals( $user['mail'], "a@b.com" );
        $this->assertEquals( $user['name'], "bob williams" );
        $this->assertEquals( $user['pass'], "12345" );
    }

    public function  testAddUser_ShortPass() {
        try {
            $this->store->addUser(  "bob williams", "bob@example.com", "ff" );
        } catch ( Exception $e ) { return; }
        $this->fail("Short password exception expected");
    }
}

?>
