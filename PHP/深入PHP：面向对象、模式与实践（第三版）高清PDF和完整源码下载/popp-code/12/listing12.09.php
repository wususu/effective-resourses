<?php
namespace woo\controller;

require_once("woo/base/Registry.php");
require_once("woo/controller/Request.php");

abstract class PageController {
    private $request;
    function __construct() {
        $request = \woo\base\RequestRegistry::getRequest();
        if ( is_null( $request ) ) { $request = new Request(); }
        $this->request = $request;
    }

    abstract function process();

    function forward( $resource ) {
        include( $resource );
        exit( 0 );
    }

    function getRequest() {
        return $this->request;
    }
}

class AddVenueController extends PageController {
    function process() {
        try {
            $request = $this->getRequest();
            $name = $request->getProperty( 'venue_name' );
            if ( is_null( $request->getProperty('submitted') ) ) {
               $request->addFeedback("choose a name for the venue");
               $this->forward( 'add_venue.php' );
            } else if ( is_null( $name ) ) {
               $request->addFeedback("name is a required field");
               $this->forward( 'add_venue.php' );
            }
            // just creating the object is enough to add it
            // to the database
            $venue = new \woo\domain\Venue( null, $name );
            $this->forward( "ListVenues.php" );
        } catch ( Exception $e ) {
            $this->forward( 'error.php' );
        }
    }
}
$controller = new AddVenueController();
$controller->process();
?>
