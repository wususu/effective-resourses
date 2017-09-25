<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * ## licencestring ##
 * @package    GetInstance
 * @author     Matt Zandstra <matt@bgz-consultants.com>
 * @copyright  2005 BGZ Consultants
 * @license    ## licencelink ##
 * @version    CVS: $Id$
 */

/**
 * requires
 */
require_once "gi/parse/Scanner.php";
require_once "gi/test/testutil/BaseTest.php";

/**
 * Unit tests for @{link \gi\parse\Scanner}
 *
 * @version    release: @package_version@
 * @author     Matt Zandstra <matt@getinstnce.com>
 * @copyright  2005 Matt Zandstra
 * @license    ## licencelink ##
 * @package    gi_test_parse
 */
class test_parse_ScannerTest extends test_testutil_BaseTest {
    protected function setUp() { 
        $this->res = dirname(__FILE__).DIRECTORY_SEPARATOR."res";
        $this->sample1 = $this->res.DIRECTORY_SEPARATOR."sample1.txt";
    }     

    protected function tearDown() { }

    public function testPants() {
        $tokenizer = new \gi\parse\Scanner( 'pants pants pants' );
        while ( $tok = $tokenizer->nextToken()
                != \gi\parse\Scanner::EOF ) {
            $val = $tokenizer->token();
            $this->say( $val ); 
        }
    }
/**
 * Test for expected tokens in a sample file
 */
    public function testToken() {
        $str = file_get_contents($this->sample1 );
        $this->say( $this->sample1 );
        self::AssertTrue( is_string( $str ), "should be string" );
        $tokenizer = new \gi\parse\Scanner( $str );
        $tok = $tokenizer->nextToken();  // this
        $val = $tokenizer->token();
        self::AssertEquals( $tok, \gi\parse\Scanner::WORD );
/*
        self::AssertEquals( $val, 'this', "got $val" );
        $tok = $tokenizer->nextToken(); // EOL
        self::AssertEquals( $tok, \gi\parse\Scanner::EOL );
        $tok = $tokenizer->nextToken(); // is
        $tok = $tokenizer->nextToken(); // SPACE
        self::AssertEquals( $tok, \gi\parse\Scanner::WHITESPACE );
        self::AssertEquals( $tokenizer->getTypeString(), "WHITESPACE" );
        $tok = $tokenizer->nextToken(); // a
        $tok = $tokenizer->nextToken(); // SPACE (four)
        $val = $tokenizer->token();
        self::AssertEquals( $tok, \gi\parse\Scanner::WHITESPACE );
        self::AssertEquals( $val, "    " );
        $tok = $tokenizer->nextToken(); // sample
        $tok = $tokenizer->nextToken(); // EOL
        $tok = $tokenizer->nextToken(); // <
        $val = $tokenizer->token();
        self::AssertEquals( $tok, \gi\parse\Scanner::CHAR );
        self::AssertEquals( $val, "<" );
        while ( ($tok = $tokenizer->nextToken()) 
                != \gi\parse\Scanner::EOF ) {
            // should not go into infinite loop!
            $count++;
            if ( $count > 1000 ) {
                self::AssertTrue( false, 'EOF not encountered' );
            } 
        }
        self::AssertTrue( true );
*/
    }
}
?>
