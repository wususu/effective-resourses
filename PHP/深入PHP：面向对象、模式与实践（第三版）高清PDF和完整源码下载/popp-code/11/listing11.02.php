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
// end previous

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

$context = new Context();
$myvar = new VariableExpression( 'input', 'four');
$myvar->interpret( $context );
print $context->lookup( $myvar )."\n";
// output: four

$newvar = new VariableExpression( 'input' );
$newvar->interpret( $context );
print $context->lookup( $newvar )."\n";
// output: four

$myvar->setValue("five");
$myvar->interpret( $context );
print $context->lookup( $myvar )."\n";
// output: five
print $context->lookup( $newvar )."\n";
// output: five
?>
