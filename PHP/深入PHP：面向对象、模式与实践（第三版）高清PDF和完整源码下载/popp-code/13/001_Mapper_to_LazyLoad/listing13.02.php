<?php
namespace woo\mapper;

$EG_DISABLE_INCLUDES=true;
//require_once( "woo/mapper/Mapper.php" );
require_once( "listing13.01.php" );
require_once( "woo/base/Exceptions.php" );
require_once( "woo/domain/Venue.php" );
//require_once( "woo/mapper/Collections.php" );
//require_once( "woo/domain.php" );

class VenueMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare( 
                            "SELECT * FROM venue WHERE id=?");
        $this->updateStmt = self::$PDO->prepare( 
                            "update venue set name=?, id=? where id=?");
        $this->insertStmt = self::$PDO->prepare( 
                            "insert into venue ( name ) 
                             values( ? )");
    } 
    
    function getCollection( array $raw ) {
        return new SpaceCollection( $raw, $this );
    }

    protected function doCreateObject( array $array ) {
        $obj = new \woo\domain\Venue( $array['id'] );
        $obj->setname( $array['name'] );
        // $space_mapper = new spacemapper();
        // $space_collection = $space_mapper->findbyvenue( $array['id'] );
        // $obj->setspaces( $space_collection );
        return $obj;
    }

    protected function doInsert( \woo\domain\DomainObject $object ) {
        print "inserting\n";
        debug_print_backtrace();
        $values = array( $object->getName() ); 
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }
    
    function update( \woo\domain\DomainObject $object ) {
        print "updating\n";
        $values = array( $object->getName(), $object->getId(), $object->getId() ); 
        $this->updateStmt->execute( $values );
    }

    function selectStmt() {
        return $this->selectStmt;
    }
}

$mapper = new VenueMapper();
$venue = $mapper->find(2);
print_r( $venue );

/*
$venue = new \woo\domain\Venue();
$venue->setName( "The Likey Lounge-yy" );
// add the object to the database
$mapper->insert( $venue );
// find the object again – just prove it works!
$venue = $mapper->find( $venue->getId() );
print_r( $venue );
// alter our object
$venue->setName( "The Bibble Beer Likey Lounge-yy" );
// call update to enter the amended data
$mapper->update( $venue );

// once again, go back to the database to prove it worked
$venue = $mapper->find( $venue->getId() );
print_r( $venue );
*/
?>
