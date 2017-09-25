<?php
namespace woo\mapper;


class IdentityObject {
    protected $parent=null;
    protected $operator=null;
    protected $field=null;
    protected $value=null;
    private $and=null;
    private $enforce=array();

    function __construct( $field=null, array $enforce=null ) {
        if ( ! is_null( $enforce ) ) {
            $this->enforce = $enforce;
        }
        if ( ! is_null( $field ) ) {
            $this->field( $field );
        }
    }

    function getField()     { return $this->field; }
    function getOperator()  { return $this->operator; }
    function getValue()     { return $this->value; }
    function next()         { return $this->and; }

    function getFields() {
        return $this->getRoot()->enforce;
    }

    function field( $field ) {
        $this->enforceField( $field );
        $this->field = $field;
        return $this;
    }

    function getRoot() {
        for ( $root=$this; (! is_null($root->parent)); $root = $root->parent ) {}
        return $root;
    }

    function enforceField( $field ) {
        $root = $this->getRoot();
        if ( ! in_array( $field, $root->enforce ) && ! empty( $root->enforce ) ) {
            $forcelist = implode( ', ', $this->enforce );
            throw new Exception("{$field} not a legal field ($forcelist)");
        }
    }

    function add( $idobj ) {
        if ( ! is_object( $idobj ) ) {
            $idobj = new self( $idobj );
        } else if ( ! $idobj instanceof self ) {
            throw new Exception("type mismatch");
        }
        $idobj->setParent( $this );
        $this->and = $idobj;
        return $idobj;
    }

    protected function setParent( IdentityObject $idobj ) {
        if ( isset( $this->field ) ) {
            $this->enforceField( $this->field );
        }
        $this->parent = $idobj;
    }

    function eq( $value ) {
        return $this->operator( "=", $value );
    }

    function lt( $value ) {
        return $this->operator( "<", $value );
    }

    function gt( $value ) {
        return $this->operator( ">", $value );
    }

    private function operator( $symbol, $value ) {
        if ( is_null( $this->field ) ) {
            throw new Exception("no object field defined");
        }
        $this->operator = $symbol;
        $this->value = $value;
        return $this;
    }

    function isVoid() {
        $root = $this->getRoot();
        return ( ! isset( $root->add ) && ! isset( $root->field ) && ! isset( $root->operator ) );
    }

    function __toString() {
        $ret = array();
        for ( $output=$this->getRoot(); ! is_null( $output ); $output=$output->and ) {
            $ret[] = "{$output->field} {$output->operator} {$output->value}";
        }
        return implode( " and ", $ret );
    }
}    
?>
