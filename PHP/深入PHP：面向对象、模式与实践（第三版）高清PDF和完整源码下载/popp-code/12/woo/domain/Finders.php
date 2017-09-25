<?php
namespace woo\domain;


interface Finder {
    function find( $id );
    function findAll();

    function update( DomainObject $object );
    function insert( DomainObject $obj );
    //function delete();
}

interface SpaceFinder extends Finder { 
    function findByVenue( $id );
}

interface VenueFinder  extends Finder { 
}

interface EventFinder  extends Finder { 
}
?>
