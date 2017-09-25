<?php
namespace woo\command;

require_once( "woo/domain/Venue.php" );

class AddVenue extends Command {
    function doExecute( \woo\controller\Request $request ) {
        $name = $request->getProperty("venue_name");
        if ( ! $name ) {
            $request->addFeedback( "no name provided" );
            return self::statuses('CMD_INSUFFICIENT_DATA');
        } else {
            $venue_obj = new \woo\domain\Venue( null, $name ); 
            $request->setObject( 'venue', $venue_obj );
            //\woo\domain\ObjectWatcher::instance()->performOperations();
            $venue_obj->finder()->insert( $venue_obj );
            $request->addFeedback( "'$name' added ({$venue_obj->getId()})" );
            return self::statuses('CMD_OK');
        }
        return self::statuses('CMD_DEFAULT');
    }
}

?>
