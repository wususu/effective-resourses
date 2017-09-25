<?php
class Person {
    protected $name;    
    private $age;    
    private $id;    

    function __construct( $name, $age ) {
        $this->name = $name;
        $this->age  = $age;
    }

    function setId( $id ) {
        $this->id = $id;
    }
    
    function __destruct() {
        if ( ! empty( $this->id ) ) {
            // save Person data
            print "saving person\n";
        }
    }
}

$person = new Person( "bob", 44 );
$person->setId( 343 );
unset( $person );

?>
