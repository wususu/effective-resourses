<?php
class Person {
    private $_name;
    private $_age;

    function __set( $property, $value ) {
        $method = "set{$property}";
        if ( method_exists( $this, $method ) ) {
            return $this->$method( $value );
        }
    }
 
    function __unset( $property ) {
        $method = "set{$property}";
        if ( method_exists( $this, $method ) ) {
            $this->$method( null );
        }
    }
                                                                        
    function setName( $name ) {
        $this->_name = $name;
        if ( ! is_null( $name ) ) {
            $this->_name = strtoupper($this->_name);
        }
    }

    function setAge( $age ) {
        $this->_age = $age;
    }
}

$p = new Person();
$p->name = "bob";
$p->age  = 44;
print_r( $p );
unset($p->name);
print_r( $p );
?>
