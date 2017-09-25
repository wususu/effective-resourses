<?php
namespace woo\mapper;

require_once("woo/mapper/SelectionFactory.php");
require_once("woo/mapper/EventIdentityObject.php");

class EventSelectionFactory extends SelectionFactory {

    function newSelection( IdentityObject $obj ) {
        $fields = implode( ',', $obj->getObjectFields() );
        $core = "SELECT $fields FROM event";
        list( $where, $values ) = $this->buildWhere( $obj );
        return array( $core." ".$where, $values );
    }
}
?>
