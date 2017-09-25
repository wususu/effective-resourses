<?php

namespace woo\domain;

class Venue {
    private $id;
    private $name; 

    function __construct( $id, $name ) {
        $this->name = $name;
        $this->id = $id;
    }
    function getName() {
        return $this->name;
    }
    function getId() {
        return $this->id;
    }
}

$x = new Venue( null, 'bob' );
$x = new Venue( 55, 'bob' );
print $x->getName();
print $x->getId();
?>
