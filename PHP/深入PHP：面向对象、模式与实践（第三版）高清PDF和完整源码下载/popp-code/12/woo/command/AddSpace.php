<?php
namespace woo\command;

//require_once( "woo/mapper/VenueMapper.php" );
require_once( "woo/domain/Venue.php" );

class AddSpace extends Command {
    function doExecute( \woo\controller\Request $request ) {
        $venue = $request->getObject( "venue" );
        if ( ! isset( $venue ) ) {
            $venue = \woo\domain\Venue::
                        find($request->getProperty( 'venue_id' ));
        }
        if ( is_null( $venue ) ) {
            $request->addFeedback( "unable to find venue" );
            return self::statuses('CMD_ERROR');
        }
        $request->setObject( "venue", $venue );

        $name = $request->getProperty("space_name");

        if ( ! isset( $name ) ) {
            $request->addFeedback( "please add name for the space" );
            return self::statuses('CMD_INSUFFICIENT_DATA');
        } else {
            $venue->addSpace( $space = new \woo\domain\Space( null, $name )); 
            $request->addFeedback( "space '$name' added ({$space->getId()})" );
            return self::statuses('CMD_OK');
        }
    }
}

?>
