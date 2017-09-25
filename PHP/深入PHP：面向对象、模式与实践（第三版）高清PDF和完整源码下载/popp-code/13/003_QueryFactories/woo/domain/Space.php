<?php
namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );

class Space extends DomainObject {
    private $name;
    private $events;
    private $venue;

    function __construct( $id=null, $name='main' ) {
        parent::__construct( $id );
        //$this->events = self::getCollection("Event");
        $this->events = null;
        $this->name = $name; 
    }

    function setEvents( EventCollection $events ) {
        $this->events = $events;
    } 

    function getEvents() {
        if ( is_null($this->events) ) {
            $idobj = new \woo\mapper\EventIdentityObject('space');
            $this->events = self::getFinder('woo\\domain\\Event')
                ->find( $idobj->eq( $this->getId() ) );
        }
        return $this->events;
    } 

    function addEvent( Event $event ) {
        $this->events->add( $event );
        $event->setSpace( $this );
    }

    function setName( $name_s ) {
        $this->name = $name_s;
        $this->markDirty();
    }

    function setVenue( Venue $venue ) {
        $this->venue = $venue;
        $this->markDirty();
    }

    function getVenue( ) {
        return $this->venue;
    }

    function getName() {
        return $this->name;
    }
}
?>
