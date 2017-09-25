<?php
namespace woo\mapper;

require_once( "woo/mapper/UpdateFactory.php");

class SpaceUpdateFactory extends UpdateFactory {

    function newUpdate( \woo\domain\DomainObject $obj ) {
        // not type checking removed
        $id = $obj->getId();
        $cond = null; 
        $values['name'] = $obj->getName();
        $values['venue'] = $obj->getVenue()->getId();

        if ( $id > -1 ) {
            $cond['id'] = $id;
        }
        return $this->buildStatement( "space", $values, $cond );
    }
}
?>
