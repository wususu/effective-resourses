<?php
namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );

class Venue extends DomainObject {
    private $name;
    private $spaces;

    function __construct( $id=null, $name=null ) {
        $this->name = $name;
        parent::__construct( $id );
    }
    
    function setSpaces( SpaceCollection $spaces ) {
        $this->spaces = $spaces;
    } 

    function getSpaces() {
        if ( ! isset( $this->spaces ) ) {
            $finder = self::getFinder( 'woo\\domain\\Space' ); 
            $this->spaces = $finder->findByVenue( $this->getId() );
            //$this->spaces = self::getCollection("woo\\domain\\Space");
        }
        return $this->spaces;
    } 

    function addSpace( Space $space ) {
        $this->getSpaces()->add( $space );
        $space->setVenue( $this );
    }

    function setName( $name_s ) {
        $this->name = $name_s;
        $this->markDirty();
    }

    function getName( ) {
        return $this->name;
    }
    
    static function findAll() {
        $finder = self::getFinder( __CLASS__ ); 
        return $finder->findAll();
    }
    static function find( $id ) {
        $finder = self::getFinder( __CLASS__ ); 
        return $finder->find( $id );
    }

}

?>
