<?php
require_once( "gi/parse/Parser.php" );
require_once( "gi/parse/StringReader.php" );
require_once( "gi/parse/Context.php" );
require_once( "parse/ML_Interpreter.php" );

class StringLiteralHandler implements \gi\parse\Handler {
    function handleMatch( \gi\parse\Parser $parser, \gi\parse\Scanner $scanner ) {
        $value = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult( new LiteralExpression( $value ) );
    }
}

class EqualsHandler implements \gi\parse\Handler {
    function handleMatch( \gi\parse\Parser $parser, \gi\parse\Scanner $scanner ) {
        $comp1 = $scanner->getContext()->popResult();
        $comp2 = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult( new EqualsExpression( $comp1, $comp2 ) );
    }
}

class VariableHandler implements \gi\parse\Handler {
    function handleMatch( \gi\parse\Parser $parser, \gi\parse\Scanner $scanner ) {
        $varname = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult( new VariableExpression( $varname ) );
    }
}

class BooleanOrHandler implements \gi\parse\Handler {
    function handleMatch( \gi\parse\Parser $parser, \gi\parse\Scanner $scanner ) {
        $comp1 = $scanner->getContext()->popResult();
        $comp2 = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult( new BooleanOrExpression( $comp1, $comp2 ) );
    }
}

class BooleanAndHandler implements \gi\parse\Handler {
    function handleMatch( \gi\parse\Parser $parser, \gi\parse\Scanner $scanner ) {
        $comp1 = $scanner->getContext()->popResult();
        $comp2 = $scanner->getContext()->popResult();
        $scanner->getContext()->pushResult( new BooleanAndExpression( $comp1, $comp2 ) );
    }
}

class MarkParse {
    private $expression;
    private $operand;
    private $interpreter;
    private $context;

    function __construct( $statement ) {
        $this->compile( $statement );
    }

    function evaluate( $input ) {
        $icontext = new InterpreterContext();
        $prefab = new VariableExpression('input', $input );
        // add the input variable to Context
        $prefab->interpret( $icontext );
 
        $this->interpreter->interpret( $icontext );
        $result = $icontext->lookup( $this->interpreter );
        return $result;
    } 

    function compile( $statement_str ) {
        // build parse tree
        $context = new \gi\parse\Context();
        $scanner = new \gi\parse\Scanner( new \gi\parse\StringReader($statement_str), $context );
        $statement = $this->expression(); 
        $scanresult = $statement->scan( $scanner );
         
        if ( ! $scanresult || $scanner->tokenType() != \gi\parse\Scanner::EOF ) {
            $msg  = "";
            $msg .= " line: {$scanner->line_no()} ";
            $msg .= " char: {$scanner->char_no()}";
            $msg .= " token: {$scanner->token()}\n";
            throw new Exception( $msg );
        }
 
        $this->interpreter = $scanner->getContext()->popResult();
    }

    function expression() {
        if ( ! isset( $this->expression ) ) {
            $this->expression = new \gi\parse\SequenceParse();
            $this->expression->add( $this->operand() );
            $bools = new \gi\parse\RepetitionParse( );
            $whichbool = new \gi\parse\AlternationParse();
            $whichbool->add( $this->orExpr() );
            $whichbool->add( $this->andExpr() );
            $bools->add( $whichbool );
            $this->expression->add( $bools );
        }
        return $this->expression;
    }

    function orExpr() {
        $or = new \gi\parse\SequenceParse( );
        $or->add( new \gi\parse\WordParse('or') )->discard();
        $or->add( $this->operand() );
        $or->setHandler( new BooleanOrHandler() );
        return $or;
    }

    function andExpr() {
        $and = new \gi\parse\SequenceParse();
        $and->add( new \gi\parse\WordParse('and') )->discard();
        $and->add( $this->operand() );
        $and->setHandler( new BooleanAndHandler() );
        return $and;
    }

    function operand() {
        if ( ! isset( $this->operand ) ) {
            $this->operand = new \gi\parse\SequenceParse( );
            $comp = new \gi\parse\AlternationParse( );
            $exp = new \gi\parse\SequenceParse( );
            $exp->add( new \gi\parse\CharacterParse( '(' ))->discard();
            $exp->add( $this->expression() );
            $exp->add( new \gi\parse\CharacterParse( ')' ))->discard();
            $comp->add( $exp ); 
            $comp->add( new \gi\parse\StringLiteralParse() )
                ->setHandler( new StringLiteralHandler() ); 
            $comp->add( $this->variable() );
            $this->operand->add( $comp );
            $this->operand->add( new \gi\parse\RepetitionParse( ) )->add($this->eqExpr());
        }
        return $this->operand;
    }

    function eqExpr() {
        $equals = new \gi\parse\SequenceParse();
        $equals->add( new \gi\parse\WordParse('equals') )->discard();
        $equals->add( $this->operand() );
        $equals->setHandler( new EqualsHandler() );
        return $equals;
    }

    function variable() {
        $variable = new \gi\parse\SequenceParse();
        $variable->add( new \gi\parse\CharacterParse( '$' ))->discard();
        $variable->add( new \gi\parse\WordParse());
        $variable->setHandler( new VariableHandler() );
        return $variable;
    }
}
?>
