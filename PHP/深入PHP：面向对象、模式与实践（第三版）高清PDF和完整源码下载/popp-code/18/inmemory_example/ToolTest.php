<?php
require_once('DBFace.php');
require_once('PHPUnit/Framework/TestCase.php');


class ToolTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $face = new DBFace("sqlite::memory:");
        $face->query("create table user ( id INTEGER PRIMARY KEY, name TEXT )");
        $face->query("insert into user (name) values('bob')");
        $face->query("insert into user (name) values('harry')");
        $this->mapper = new ToolMapper( $face );
        /*
        $result = $x->query("select * from user");

        while ( $row = $result->fetch() ) {
            print_r( $row );
        }
        */
    }

    function testTool() {
        self::AssertTrue( true );
    }
}

class ToolMapper {
    function __construct( DBFace $face ) {
        //..
    }
}
?>
