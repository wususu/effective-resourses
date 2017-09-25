<?php
class PersonWriter {

    function writeName( Person $p ) {
        print $p->getName()."\n";
    }

    function writeAge( Person $p ) {
        print $p->getAge()."\n";
    }
}

class Person {
    private $writer;

    function __construct( PersonWriter $writer ) {
        $this->writer = $writer;
    }

    function __call( $method, $args ) {
        if ( method_exists( $this->writer, $method ) ) {
            return $this->writer->$method( $this );
        }
    }

    function getName()  { return "Bob"; }
    function getAge() { return 44; }
}

$person= new Person( new PersonWriter() );
$person->writeName();
$person->writeAge();
?>
