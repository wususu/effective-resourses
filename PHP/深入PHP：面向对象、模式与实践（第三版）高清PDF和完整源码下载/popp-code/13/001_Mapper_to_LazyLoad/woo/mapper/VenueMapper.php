<?php
namespace woo\mapper;


require_once( "woo/mapper/Mapper.php" );
require_once( "woo/base/Exceptions.php" );
require_once( "woo/mapper/Collections.php" );
require_once( "woo/domain.php" );

class VenueMapper extends Mapper 
                             implements \woo\domain\VenueFinder {

    function __construct() {
        parent::__construct();
        $this->selectAllStmt = self::$PDO->prepare( 
                            "SELECT * FROM venue");
        $this->selectStmt = self::$PDO->prepare( 
                            "SELECT * FROM venue WHERE id=?");
        $this->updateStmt = self::$PDO->prepare( 
                            "UPDATE venue SET name=?, id=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare( 
                            "INSERT into venue ( name ) 
                             values( ? )");
    } 
    
    function getCollection( array $raw ) {
        return new SpaceCollection( $raw, $this );
    }

    protected function doCreateObject( array $array ) {
        $obj = new \woo\domain\Venue( $array['id'] );
        $obj->setname( $array['name'] );
        //$space_mapper = new SpaceMapper();
        //$space_collection = $space_mapper->findByVenue( $array['id'] );
        //$obj->setSpaces( $space_collection );
        return $obj;
    }

    protected function targetClass() {
        return "woo\\domain\\Venue";
    }

    protected function doInsert( \woo\domain\DomainObject $object ) {
        $values = array( $object->getname() ); 
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }
    
    function update( \woo\domain\DomainObject $object ) {
        $values = array( $object->getname(), $object->getid(), $object->getId() ); 
        $this->updateStmt->execute( $values );
    }

    function selectStmt() {
        return $this->selectStmt;
    }

    function selectAllStmt() {
        return $this->selectAllStmt;
    }

}
?>
