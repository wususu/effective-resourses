<?php
// start previous
abstract class Expression {
    private static $keycount=0;
    private $key;
    abstract function interpret( Context $context );

    function getKey() {
        if ( ! isset( $this->key ) ) {
            self::$keycount++;
            $this->key=self::$keycount;
        }
        return $this->key;
    }
}

class LiteralExpression extends Expression {
    private $value;

    function __construct( $value ) {
        $this->value = $value;
    }

    function interpret( Context $context ) {
        $context->replace( $this, $this->value );
    }
}

class Context {
    private $expressionstore = array();
    function replace( Expression $exp, $value ) {
        $this->expressionstore[$exp->getKey()] = $value;
    }

    function lookup( Expression $exp ) {
        return $this->expressionstore[$exp->getKey()];
    }
}

class VariableExpression extends Expression {
    private $name;
    private $val;

    function __construct( $name, $val=null ) {
        $this->name = $name;
        $this->val = $val;
    }

    function interpret( Context $context ) {
        if ( ! is_null( $this->val ) ) {
            $context->replace( $this, $this->val );
            $this->val = null;
        }
    }

    function setValue( $value ) {
        $this->val = $value;
    }

    function getKey() {
        return $this->name;
    }
}

// end previous


abstract class OperatorExpression extends Expression {
    protected $l_op;
    protected $r_op;

    function __construct( Expression $l_op, Expression $r_op ) {
        $this->l_op = $l_op;
        $this->r_op = $r_op;
    }

    function interpret( Context $context ) {
        $this->l_op->interpret( $context );
        $this->r_op->interpret( $context );
        $result_l = $context->lookup( $this->l_op );
        $result_r = $context->lookup( $this->r_op  );
        $this->doInterpret( $context, $result_l, $result_r );
    }

    protected abstract function doInterpret( Context $context, 
                                             $result_l, 
                                             $result_r );
}


class EqualsExpression extends OperatorExpression {
    protected function doInterpret( Context $context, 
                                        $result_l, $result_r ) {
            $context->replace( $this, $result_l == $result_r );
    }
}

class BooleanOrExpression extends OperatorExpression {
    protected function doInterpret( Context $context, 
                                        $result_l, $result_r ) {
        $context->replace( $this, $result_l || $result_r );
    }
}

class BooleanAndExpression extends OperatorExpression {
    protected function doInterpret( Context $context, 
                                        $result_l, $result_r ) {
        $context->replace( $this, $result_l && $result_r );
    }
}

$context = new Context();
$input = new VariableExpression( 'input' );
$statement = new BooleanOrExpression( 
    new EqualsExpression( $input, new LiteralExpression( 'four' ) ),
    new EqualsExpression( $input, new LiteralExpression( '4' ) ) 
);

foreach ( array( "four", "4", "52" ) as $val ) {
    $input->setValue( $val ); 
    print "$val:\n";
    $statement->interpret( $context );
    if ( $context->lookup( $statement ) ) {
        print "top marks\n\n";
    } else {
        print "dunce hat on\n\n";
    }
}

?>
