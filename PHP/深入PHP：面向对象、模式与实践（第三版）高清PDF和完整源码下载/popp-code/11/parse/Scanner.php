<?php

class Scanner {
    const WORD         = 1;
    const QUOTE        = 2;
    const APOS         = 3;
    const WHITESPACE   = 6;
    const EOL          = 8;
    const CHAR         = 99;
    const EOF          = 0;

    protected $in;
    protected $line_no = 1;
    protected $char_no = 0;
    protected $token;
    protected $token_type;
    protected $regexps;
    public $resultstack = array();

    function __construct( $in ) {
        $this->in = $in;
        $this->setRegexps();
        $this->nextToken();
        $this->eatWhiteSpace();
    }

    // push a result on to the result stack
    function pushResult( $mixed ) {
        array_push( $this->resultstack, $mixed );
    }

    // remove result from result stack
    function popResult( ) {
        return array_pop( $this->resultstack );
    }

    // number of items on the result stack
    function resultCount() {
        return count( $this->resultstack );
    }

    // return the last item on the result stack but
    // don't remove 
    function peekResult( ) {
        if ( empty( $this->resultstack ) ) {
            throw new Exception( "empty resultstack" );
        }
        return $this->resultstack[count( $this->resultstack ) -1 ];
    }

    // set up regular expressions for tokens
    private function setRegexps() {
        $this->regexps = array( 
                      self::WHITESPACE => '[ \t]', 
                      self::EOL => '\n', 
                      self::WORD => '[a-zA-Z0-9_-]+\b',
                      self::QUOTE => '"',
                      self::APOS => "'",
        );

        $this->typestrings = array( 
                      self::WHITESPACE => 'WHITESPACE', 
                      self::EOL => 'EOL', 
                      self::WORD => 'WORD',
                      self::QUOTE => 'QUOTE',
                      self::APOS => "APOS",
                      self::CHAR  => 'CHAR',
                      self::EOF => 'EOF'
        );
    }

    // skip through any white space
    function eatWhiteSpace( ) {
        $ret = 0;
        if ( $this->token_type != self::WHITESPACE && 
             $this->token_type != self::EOL ) {
            return $ret;
        }
        while ( $this->nextToken() == self::WHITESPACE || 
                $this->token_type == self::EOL ) {
            $ret++;
        }
        return $ret;
    }

    // given a constant number, return a
    // string version
    // eg 1 => 'WORD',
    function getTypeString( $int=-1 ) {
        if ( $int<0 ) {
            $int=$this->token_type(); 
        }
        return $this->typestrings[$int];
    }

    // the type of the current token
    function token_type() {
        return $this->token_type;
    }

    // the text being scanned
    // gets shorter as the tokens are
    // pulled from it
    function input() {
        return $this->in;
    }

    // the current token
    function token() {
        return $this->token;
    }

    // the current line number (great for error messages)
    function line_no() {
        return $this->line_no;
    }

    // current char_no
    function char_no() {
        return $this->char_no;
    }

    // attempt to pull another token from 
    // the input. If no token match is found then
    // it's a character token
    function nextToken() {
        if ( ! strlen( $this->in ) ) {
            return ( $this->token_type = self::EOF );
        }

        $ret = 0;
        foreach ( $this->regexps as $type=>$regex ) {        
            if ( $ret = $this->testToken( $regex, $type ) ) {
                if ( $ret == self::EOL ) {
                    $this->line_no++;
                    $this->char_no = 0;
                } else {
                    $this->char_no += strlen( $this->token() );
                }
                return $ret;
            }
        }
        $this->token = substr( $this->in, 0, 1 );
        $this->in    = substr( $this->in, 1 );
        $this->char_no += 1;
        return ( $this->token_type = self::CHAR );
    }

    // given a regular expression check for a match
    private function testToken( $regex, $type ) {
        $matches = array();
        if ( preg_match( "/^($regex)(.*)/s", $this->in, $matches ) ) {
            $this->token = $matches[1];
            $this->in    = $matches[2];
            return ( $this->token_type  = $type );
        }
        return 0;
    }

    // given another scanner, make this one a clone
    function updateToMatch( Scanner $other ) {
        $this->in = $other->in;
        $this->token = $other->token;
        $this->token_type = $other->token_type;
        $this->char_no = $other->char_no;
        $this->line_no = $other->line_no;
        $this->resultstack = $other->resultstack;
    }
}
?>
