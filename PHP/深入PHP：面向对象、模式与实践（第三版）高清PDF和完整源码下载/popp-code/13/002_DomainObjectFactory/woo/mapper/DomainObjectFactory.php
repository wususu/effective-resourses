<?php
namespace woo\mapper;


abstract class DomainObjectFactory {
    abstract function createObject( array $array );

    protected function getFromMap( $class, $id ) {
        return \woo\domain\ObjectWatcher::exists( $class, $id );
    }

    protected function addToMap( \woo\domain\DomainObject $obj ) {
        return \woo\domain\ObjectWatcher::add( $obj );
    }

}

class VenueObjectFactory extends DomainObjectFactory {
    function createObject( array $array ) {
        $class = '\woo\domain\Venue';
        $old = $this->getFromMap( $class, $array['id'] );
        if ( $old ) { return $old; }
        $obj = new $class( $array['id'] );
        $obj->setname( $array['name'] );
        //$space_mapper = new SpaceMapper();
        //$space_collection = $space_mapper->findByVenue( $array['id'] );
        //$obj->setSpaces( $space_collection );
        $this->addToMap( $obj );
        return $obj;
    }
}

class SpaceObjectFactory extends DomainObjectFactory {
    function createObject( array $array ) {
        $class = '\woo\domain\Space';
        $old = $this->getFromMap( $class, $array['id'] );
        if ( $old ) { return $old; }
        $obj = new $class( $array['id'] );
        $obj->setname( $array['name'] );
        $ven_mapper = new VenueMapper();
        $venue = $ven_mapper->find( $array['venue'] );
        $obj->setVenue( $venue );

        $event_mapper = new EventMapper();
        $event_collection = $event_mapper->findBySpaceId( $array['id'] );        
        $obj->setEvents( $event_collection );
        return $obj;
    }
}

class EventObjectFactory extends DomainObjectFactory {
    function createObject( array $array ) {
        $class = '\woo\domain\Event';
        $old = $this->getFromMap( $class, $array['id'] );
        $obj = new $class( $array['id'] );
        $obj->setstart( $array['start'] );
        $obj->setduration( $array['duration'] );
        $obj->setname( $array['name'] );
        $space_mapper = new SpaceMapper();
        $space = $space_mapper->find( $array['space'] );
        $obj->setSpace( $space );

        return $obj;
    }
}

?>
