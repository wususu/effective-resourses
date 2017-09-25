<?php
require_once( "parse/Parser.php" );

class StringLiteralHandler implements Handler {
    function handleMatch( Parser $parser, Scanner $scanner ) {
        $value = $scanner->popResult();
        $scanner->pushResult( new LiteralExpression( $value ) );
    }
}

class EqualsHandler implements Handler {
    function handleMatch( Parser $parser, Scanner $scanner ) {
        $comp1 = $scanner->popResult();
        $comp2 = $scanner->popResult();
        $scanner->pushResult( new EqualsExpression( $comp1, $comp2 ) );
    }
}

class VariableHandler implements Handler {
    function handleMatch( Parser $parser, Scanner $scanner ) {
        $varname = $scanner->popResult();
        $scanner->pushResult( new VariableExpression( $varname ) );
    }
}

class BooleanOrHandler implements Handler {
    function handleMatch( Parser $parser, Scanner $scanner ) {
        $comp1 = $scanner->popResult();
        $comp2 = $scanner->popResult();
        $scanner->pushResult( new BooleanOrExpression( $comp1, $comp2 ) );
    }
}

class BooleanAndHandler implements Handler {
    function handleMatch( Parser $parser, Scanner $scanner ) {
        $comp1 = $scanner->popResult();
        $comp2 = $scanner->popResult();
        $scanner->pushResult( new BooleanAndExpression( $comp1, $comp2 ) );
    }
}

class MarkParse {
    private $expression;
    private $operand;
    private $interpreter;

    function __construct( $statement ) {
        $this->compile( $statement );
    }

    function evaluate( $input ) {
        $context = new Context();
        $prefab = new VariableExpression('input', $input );
        // add the input variable to Context
        $prefab->interpret( $context );
 
        $this->interpreter->interpret( $context );
        $result = $context->lookup( $this->interpreter );
        return $result;
    } 

    function compile( $statement ) {
        // build parse tree
        $scanner = new Scanner( $statement );
        $statement = $this->expression(); 
        $scanresult = $statement->scan( $scanner );
         
        if ( ! $scanresult || $scanner->token_type() != Scanner::EOF ) {
            $msg  = "";
            $msg .= " line: {$scanner->line_no()} ";
            $msg .= " char: {$scanner->char_no()}";
            $msg .= " token: {$scanner->token()}\n";
            throw new Exception( $msg );
        }
 
        $this->interpreter = $scanner->popResult();
    }

    function expression() {
        if ( ! isset( $this->expression ) ) {
            $this->expression = new SequenceParse();
            $this->expression->add( $this->operand() );
            $bools = new RepetitionParse( );
            $whichbool = new AlternationParse();
            $whichbool->add( $this->orExpr() );
            $whichbool->add( $this->andExpr() );
            $bools->add( $whichbool );
            $this->expression->add( $bools );
        }
        return $this->expression;
    }

    function orExpr() {
        $or = new SequenceParse( );
        $or->add( new WordParse('or') )->discard();
        $or->add( $this->operand() );
        $or->setHandler( new BooleanOrHandler() );
        return $or;
    }

    function andExpr() {
        $and = new SequenceParse();
        $and->add( new WordParse('and') )->discard();
        $and->add( $this->operand() );
        $and->setHandler( new BooleanAndHandler() );
        return $and;
    }

    function operand() {
        if ( ! isset( $this->operand ) ) {
            $this->operand = new SequenceParse( );
            $comp = new AlternationParse( );
            $exp = new SequenceParse( );
            $exp->add( new CharacterParse( '(' ))->discard();
            $exp->add( $this->expression() );
            $exp->add( new CharacterParse( ')' ))->discard();
            $comp->add( $exp ); 
            $comp->add( new StringLiteralParse() )
                ->setHandler( new StringLiteralHandler() ); 
            $comp->add( $this->variable() );
            $this->operand->add( $comp );
            $this->operand->add( new RepetitionParse( ) )->add($this->eqExpr());
        }
        return $this->operand;
    }

    function eqExpr() {
        $equals = new SequenceParse();
        $equals->add( new WordParse('equals') )->discard();
        $equals->add( $this->operand() );
        $equals->setHandler( new EqualsHandler() );
        return $equals;
    }

    function variable() {
        $variable = new SequenceParse();
        $variable->add( new CharacterParse( '$' ))->discard();
        $variable->add( new WordParse());
        $variable->setHandler( new VariableHandler() );
        return $variable;
    }
}
?>
