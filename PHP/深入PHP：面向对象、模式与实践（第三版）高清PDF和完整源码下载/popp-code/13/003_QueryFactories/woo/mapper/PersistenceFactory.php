<?php
namespace woo\mapper;

require_once( "woo/mapper/Collections.php" );
require_once( "woo/mapper/DomainObjectFactory.php" );
require_once( "woo/mapper/VenueSelectionFactory.php" );
require_once( "woo/mapper/VenueUpdateFactory.php" );
require_once( "woo/mapper/VenueIdentityObject.php" );
require_once( "woo/mapper/SpaceSelectionFactory.php" );
require_once( "woo/mapper/SpaceUpdateFactory.php" );
require_once( "woo/mapper/VenueIdentityObject.php" );
require_once( "woo/mapper/EventSelectionFactory.php" );
require_once( "woo/mapper/EventUpdateFactory.php" );
require_once( "woo/mapper/EventIdentityObject.php" );

abstract class PersistenceFactory {

    abstract function getMapper();
    abstract function getDomainObjectFactory();
    abstract function getCollection( array $array );
    abstract function getSelectionFactory();
    abstract function getUpdateFactory();

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

    function getSelectionFactory() {
        return new VenueSelectionFactory();
    }

    function getUpdateFactory() {
        return new VenueUpdateFactory();
    }

    function getIdentityObject() {
        return new VenueIdentityObject();
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

    function getSelectionFactory() {
        return new SpaceSelectionFactory();
    }

    function getUpdateFactory() {
        return new SpaceUpdateFactory();
    }

    function getIdentityObject() {
        return new SpaceIdentityObject();
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

    function getSelectionFactory() {
        return new EventSelectionFactory();
    }

    function getUpdateFactory() {
        return new EventUpdateFactory();
    }

    function getIdentityObject() {
        return new EventIdentityObject();
    }

}

?>
