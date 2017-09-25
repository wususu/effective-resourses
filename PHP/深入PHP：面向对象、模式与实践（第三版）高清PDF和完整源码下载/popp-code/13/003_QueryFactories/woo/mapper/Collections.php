<?php
namespace woo\mapper;

require_once( "woo/domain/Collections.php" ); 
require_once( "woo/mapper/Collection.php" ); 
require_once( "woo/domain/Venue.php" ); 

class VenueCollection 
        extends Collection
        implements \woo\domain\VenueCollection {

    function targetClass( ) {
        return "\woo\domain\Venue";
    }
}

class SpaceCollection 
        extends Collection
        implements \woo\domain\SpaceCollection {

    function targetClass( ) {
        return "\woo\domain\Space";
    }
}

class EventCollection 
        extends Collection
        implements \woo\domain\EventCollection {

    function targetClass( ) {
        return "\woo\domain\Event";
    }
}

class DeferredEventCollection 
        extends EventCollection {
    private $stmt;
    private $valueArray;
    private $run=false;

    function __construct( DomainObjectFactory $dofact, PDOStatement $stmt_handle, 
                        array $valueArray ) {
        parent::__construct( null, $dofact ); 
        $this->stmt = $stmt_handle;
        $this->valueArray = $valueArray;
    }

    function notifyAccess() {
        if ( ! $this->run ) {
            $this->stmt->execute( $this->valueArray );
            $this->raw = $this->stmt->fetchAll();
            $this->total = count( $this->raw );
        } 
        $this->run=true;
    }
}

?>
