<?php
namespace woo\domain;

require_once( "woo/domain/DomainObject.php" );
require_once( "woo/mapper/SpaceIdentityObject.php" );

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
            $idobj = new \woo\mapper\SpaceIdentityObject('venue');
            $this->spaces = $finder->find( $idobj->eq( $this->getId() ) );
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
        $idobj = new \woo\mapper\VenueIdentityObject( );
        return $finder->find( $idobj );
    }
    static function find( $id ) {
        $finder = self::getFinder( __CLASS__ ); 
        $idobj = new \woo\mapper\VenueIdentityObject( 'id' );
        return $finder->findOne( $idobj->eq( $id ) );
    }

}

?>
