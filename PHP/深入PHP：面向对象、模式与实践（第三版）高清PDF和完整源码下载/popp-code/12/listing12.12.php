<?php
namespace woo\domain;

abstract class DomainObject {
    private $id;

    function __construct( $id=null ) {
        $this->id = $id;
    }

    function getId( ) {
        return $this->id;
    }

    static function getCollection( $type ) {
        return array(); // dummy
    }
 
    function collection() {
        return self::getCollection( get_class( $this ) );
    }
}

class Venue extends DomainObject {
    private $name;
    private $spaces;

    function __construct( $id=null, $name=null ) {
        $this->name = $name;
        $this->spaces = self::getCollection("\\woo\\domain\\Space");
        parent::__construct( $id );
    }

    function setSpaces( SpaceCollection $spaces ) {
        $this->spaces = $spaces;
    }

    function getSpaces() {
        return $this->spaces;
    }

    function addSpace( Space $space ) {
        $this->spaces->add( $space );
        $space->setVenue( $this );
    }

    function setName( $name_s ) {
        $this->name = $name_s;
        $this->markDirty();
    }

    function getName( ) {
        return $this->name;
    }
}

$v = new Venue( null, "The grep and grouch" );
?>
