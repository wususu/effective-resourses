<?php
class Person {
    private $name;    
    private $age;    
    private $id;    

    function __construct( $name, $age ) {
        $this->name = $name;
        $this->age = $age;
    }

    function setId( $id ) {
        $this->id = $id;
    }
    
    function __clone() {
        $this->id = 0;
    }
}

$person = new Person( "bob", 44 );
$person->setId( 343 );
$person2 = clone $person;
print_r( $person );
print_r( $person2 );

?>
