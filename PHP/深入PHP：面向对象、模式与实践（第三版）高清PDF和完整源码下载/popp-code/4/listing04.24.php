<?php
class Person {
    function __get( $property ) {
        $method = "get{$property}";
        if ( method_exists( $this, $method ) ) {
            return $this->$method();
        }
    }

    function __isset( $property ) {
        $method = "get{$property}";
        return ( method_exists( $this, $method ) );
    }  

    function getName() {
        return "Bob";
    }
                                                                                
    function getAge() {
        return 44;
    }
}

$p = new Person();
if ( isset( $p->name ) ) {
    print $p->name;
} else {
    print "nope\n";
}
// output: 
// Bob
?>
