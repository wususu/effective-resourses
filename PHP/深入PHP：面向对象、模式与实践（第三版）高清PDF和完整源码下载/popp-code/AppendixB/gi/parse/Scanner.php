<?php
namespace gi\parse;

require_once( "gi/parse/Reader.php" );

class Scanner {
    const WORD         = 1;
    const QUOTE        = 2;
    const APOS         = 3;
    const WHITESPACE   = 6;
    const EOL          = 8;
    const CHAR         = 9;
    const EOF          = 0;
    const SOF          = -1;

    protected $line_no = 1;
    protected $char_no = 0;
    protected $token = null;
    protected $token_type = -1;

    function __construct( Reader $r, Context $context ) {
        $this->r = $r;
        $this->context = $context;
    }
    
    function getContext() {
        return $this->context;
    }

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

    function getTypeString( $int=-1 ) {
        if ( $int<0 ) { $int=$this->tokenType(); }
        if ( $int<0 ) { return null; }
        $resolve = array(  
            self::WORD =>       'WORD', 
            self::QUOTE =>      'QUOTE', 
            self::APOS =>       'APOS', 
            self::WHITESPACE => 'WHITESPACE', 
            self::EOL =>        'EOL', 
            self::CHAR =>       'CHAR', 
            self::EOF =>        'EOF' );
        return $resolve[$int];
    }

    function tokenType() {
        return $this->token_type;
    }

    function token() {
        return $this->token;
    }

    function isWord( ) {
        return ( $this->token_type == self::WORD );
    }

    function isQuote( ) {
        return ( $this->token_type == self::APOS || $this->token_type == self::QUOTE );
    }

    function line_no() {
        return $this->line_no;
    }

    function char_no() {
        return $this->char_no;
    }

    function __clone() {
        $this->r = clone($this->r);
    }

    function nextToken() {
        $this->token = null;
        $type;
        while ( ! is_bool($char=$this->getChar())   ) {
            if ( $this->isEolChar( $char ) ) {
                $this->token = $this->manageEolChars( $char );
                $this->line_no++;
                $this->char_no = 0;
                $type = self::EOL;
                return ( $this->token_type = self::EOL );

            } else if ( $this->isWordChar( $char ) ) {
                $this->token = $this->eatWordChars( $char );
                $type = self::WORD;

            } else if ( $this->isSpaceChar( $char ) ) {
                $this->token = $char;
                $type = self::WHITESPACE;

            } else if ( $char == "'" ) {
                $this->token = $char;
                $type = self::APOS;
 
            } else if ( $char == '"' ) {
                $this->token = $char;
                $type = self::QUOTE;

            } else {
                $type = self::CHAR;
                $this->token = $char;
            }

            $this->char_no += strlen( $this->token() );
            return ( $this->token_type = $type );
        } 
        return ( $this->token_type = self::EOF );
    }

    function peekToken() {
        $state = $this->getState();
        $type = $this->nextToken(); 
        $token = $this->token();
        $this->setState( $state );
        return array( $type, $token );
    }

    function getState() {
        $state = new ScannerState();
        $state->line_no      = $this->line_no;
        $state->char_no      = $this->char_no;
        $state->token        = $this->token;
        $state->token_type   = $this->token_type;
        $state->r            = clone($this->r);
        $state->context      = clone($this->context);
        return $state;
    }

    function setState( ScannerState $state ) {
        $this->line_no      = $state->line_no;
        $this->char_no      = $state->char_no;
        $this->token        = $state->token;
        $this->token_type   = $state->token_type;
        $this->r            = $state->r;
        $this->context      = $state->context;
    }

    private function getChar() {
        return $this->r->getChar();
    }

    private function eatWordChars( $char ) {
        $val = $char;
        while ( $this->isWordChar( $char=$this->getChar() )) {
            $val .= $char;
        } 
        if ( $char ) {
            $this->pushBackChar( );
        }
        return $val;
    }

    private function eatSpaceChars( $char ) {
        $val = $char;
        while ( $this->isSpaceChar( $char=$this->getChar() )) {
            $val .= $char;
        } 
        $this->pushBackChar( );
        return $val;
    }

    private function pushBackChar( ) {
        $this->r->pushBackChar();
    }

    private function isWordChar( $char ) {
        return preg_match( "/[A-Za-z0-9_\-]/", $char );
    }

    private function isSpaceChar( $char ) {
        return preg_match( "/\t| /", $char );
    }

    private function isEolChar( $char ) {
        return preg_match( "/\n|\r/", $char );
    }

    private function manageEolChars( $char ) {
        if ( $char == "\r" ) {
            $next_char=$this->getChar();
            if ( $next_char == "\n" ) {
                return "{$char}{$next_char}";
            } else {
                $this->pushBackChar();
            }
        }
        return $char;
    }
    function getPos() {
        return $this->r->getPos();
    }

}

class ScannerState {
    public $line_no;
    public $char_no;
    public $token;
    public $token_type;
    public $r;
}

?>
