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
        $obj->markClean();
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
        /*
        $ven_mapper = new VenueMapper();
        $venue = $ven_mapper->find( $array['venue'] );
        $obj->setVenue( $venue );
        */
        
        $factory = PersistenceFactory::getFactory( 'woo\domain\Venue' );
        $ven_assembler = new DomainObjectAssembler( $factory );
        $ven_idobj = new VenueIdentityObject('id');
        $ven_idobj->eq( $array['venue'] );
        $venue = $ven_assembler->findOne( $ven_idobj );

        $factory = PersistenceFactory::getFactory( 'woo\domain\Event' );
        $event_assembler = new DomainObjectAssembler( $factory );
        $event_idobj = new EventIdentityObject('space');
        $event_idobj->eq( $array['id'] );
        $event_collection = $event_assembler->find( $event_idobj );
        $obj->setEvents( $event_collection );
        $obj->markClean();
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
        //$space_mapper = new SpaceMapper();
        //$space = $space_mapper->findOne( $array['space'] );

        $factory = PersistenceFactory::getFactory( 'woo\domain\Space' );
        $spc_assembler = new DomainObjectAssembler( $factory );
        $spc_idobj = new SpaceIdentityObject('id');
        $spc_idobj->eq( $array['space'] );
        $space = $spc_assembler->findOne( $spc_idobj );


        $obj->setSpace( $space );
        $obj->markClean();
        return $obj;
    }
}

?>
