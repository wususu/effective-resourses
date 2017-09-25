<?php
namespace woo\mapper;

require_once("woo/mapper/IdentityObject.php");

class VenueIdentityObject extends IdentityObject {
    function __construct( $field=null ) {
       parent::__construct( $field, array('name', 'id' ) ); 
    }
}

?>
