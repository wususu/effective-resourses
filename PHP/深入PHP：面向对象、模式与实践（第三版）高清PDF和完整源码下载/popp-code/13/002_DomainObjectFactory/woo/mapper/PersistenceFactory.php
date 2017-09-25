<?php
namespace woo\mapper;

require_once( "woo/mapper/Collections.php" );
require_once( "woo/mapper/DomainObjectFactory.php" );

abstract class PersistenceFactory {

    abstract function getMapper();
    abstract function getDomainObjectFactory();
    abstract function getCollection( array $array );

    static function getFactory( $target_class ) {
        switch ( $target_class ) {
            case "woo\\domain\\Venue";
                return new VenuePersistenceFactory();
                break;
            case "woo\\domain\\Event";
                return new EventPersistenceFactory();
                break;
            case "woo\\domain\\Space";
                return new SpacePersistenceFactory();
                break;
        }
    }
}

class VenuePersistenceFactory extends PersistenceFactory {
    function getMapper() {
        return new VenueMapper();
    }

    function getDomainObjectFactory() {
        return new VenueObjectFactory();
    }

    function getCollection( array $array ) {
        return new VenueCollection( $array, $this->getDomainObjectFactory() );
    }
}

class SpacePersistenceFactory extends PersistenceFactory {
    function getMapper() {
        return new SpaceMapper();
    }

    function getDomainObjectFactory() {
        return new SpaceObjectFactory();
    }

    function getCollection( array $array ) {
        return new SpaceCollection( $array, $this->getDomainObjectFactory() );
    }
}

class EventPersistenceFactory extends PersistenceFactory {
    function getMapper() {
        return new EventMapper();
    }

    function getDomainObjectFactory() {
        return new EventObjectFactory();
    }

    function getCollection( array $array ) {
        return new EventCollection( $array, $this->getDomainObjectFactory() );
    }
}

?>
