<?php
require_once('parse/Scanner.php');
require_once('parse/ML_Interpreter.php');

interface Handler {
    function handleMatch( Parser $parser, Scanner $scanner );
}

abstract class Parser {
    protected $debug = true;
    protected   $discard = false;
    protected $name;

    function __construct( $name=null ) {
        if ( is_null( $name ) ) {
            $this->name = get_class($this);
        } else {
            $this->name = $name;
        }
    }

    function setHandler( Handler $handler ) {
        $this->handler = $handler;
    }

    function invokeHandler( Scanner $scanner ) {
        if ( ! empty( $this->handler ) ) {
            if ( $this->debug ) {
                $this->report( "calling handler: ".get_class( $this->handler ) );
            }
            $this->handler->handleMatch( $this, $scanner );
        }
    }

    function report( $msg ) {
        print "<{$this->name}> ".get_class( $this ).": $msg\n"; 
    }

    function push( Scanner $scanner ) {
        if ( $this->debug ) {
            $this->report("pushing {$scanner->token()}");
        }
        $scanner->pushResult( $scanner->token() );
    }

    function scan( Scanner $scanner ) {
        $ret = $this->doScan( $scanner );
        if ( $ret && ! $this->discard && $this->term() ) {
            $this->push( $scanner );
        }
        if ( $ret ) { 
            $this->invokeHandler( $scanner );
        }
        if ( $this->debug ) {
            $this->report("::scan returning $ret");
        }
        if ( $this->term() && $ret ) {
            $scanner->nextToken();
            $scanner->eatWhiteSpace();
        }

        return $ret;
    }

    function discard() {
        $this->discard = true;
    }

    abstract function trigger( Scanner $scanner );

    abstract protected function doScan( Scanner $scan );

    function term() {
        return true;
    }
}

abstract class CollectionParse extends Parser {
    protected $parsers = array();

   function add( Parser $p ) {
        if ( is_null( $p ) ) {
            throw new Exception( "argument is null" );
        }
        $this->parsers[]= $p;
        return $p;
    }

   function term() {
        return false;
    }
}

class RepetitionParse extends CollectionParse {
    function trigger( Scanner $scanner ) {
        return true;
    }

    protected function doScan( Scanner $scanner ) {
        $s_copy = clone $scanner;
        if ( empty( $this->parsers ) ) {
            return true;
        }
        $parser = $this->parsers[0];
        $count = 0;

        while ( true ) {
            if ( ! $parser->trigger( $s_copy ) ) {
                $scanner->updateToMatch( $s_copy );
                return true;
            }

            $s_copy2 = clone $s_copy;
            if ( ! $parser->scan( $s_copy2 ) ) {
                $scanner->updateToMatch( $s_copy );
                return true;
            }
            $count++;
            $s_copy = $s_copy2;
        }
        return true;
    }
}

class AlternationParse extends CollectionParse {

    function trigger( Scanner $scanner ) {
        foreach ( $this->parsers as $parser ) {
            if ( $parser->trigger( $scanner ) ) {
                return true;
            }
        }
        return false;
    }

    protected function doScan( Scanner $scanner ) {
        $type = $scanner->token_type();
        foreach ( $this->parsers as $parser ) {
            $s_copy = clone $scanner;
            if ( $type == $parser->trigger( $s_copy ) && 
                 $parser->scan( $s_copy ) ) {
                 $scanner->updateToMatch($s_copy);
                 return true;
            }
        }
        return false;
    }
}

class SequenceParse extends CollectionParse {

    function trigger( Scanner $scanner ) {
        if ( empty( $this->parsers ) ) {
            return false;
        }
        return $this->parsers[0]->trigger( $scanner ); 
    }
 
    protected function doScan( Scanner $scanner ) {
        $s_copy = clone $scanner;
        foreach( $this->parsers as $parser ) {
            if ( ! ( $parser->trigger( $s_copy ) && 
                    $scan=$parser->scan( $s_copy )) ) {
                return false;
            }
        }
        $scanner->updateToMatch( $s_copy );
        return true;
    }
}

class CharacterParse extends Parser {
    private $char;

    function __construct( $char, $name=null ) {
        parent::__construct( $name );
        $this->char = $char;
    }

    function trigger( Scanner $scanner ) {
        return ( $scanner->token() == $this->char );
    }

    protected function doScan( Scanner $scanner ) {
        return ( $this->trigger( $scanner ) );
    } 
}

class StringLiteralParse extends Parser {

    function trigger( Scanner $scanner ) {
        return ( $scanner->token_type() == Scanner::APOS || 
                 $scanner->token_type() == Scanner::QUOTE );
    }

    function push( Scanner $scanner ) {
        return;
    }

    protected function doScan( Scanner $scanner ) {
        $quotechar = $scanner->token_type();
        $ret = false;
        $string = "";
        while ( $token = $scanner->nextToken() ) {
            if ( $token == $quotechar ) {
                $ret = true;
                break;
            }
            $string .= $scanner->token();
        } 

        if ( $string && ! $this->discard ) { 
            $scanner->pushResult( $string );
        }

        return $ret;
    } 
}

class WordParse extends Parser {
    function __construct( $word=null, $name=null ) {
        parent::__construct( $name );
        $this->word = $word;
    }

    function trigger( Scanner $scanner ) {
        if ( $scanner->token_type() != Scanner::WORD ) {
            return false;
        }
        if ( is_null( $this->word ) ) {
            return true;
        }
        return ( $this->word == $scanner->token() );
    }

    protected function doScan( Scanner $scanner ) {
        $ret = ( $this->trigger( $scanner ) );
        return $ret;
    } 
}
?>
