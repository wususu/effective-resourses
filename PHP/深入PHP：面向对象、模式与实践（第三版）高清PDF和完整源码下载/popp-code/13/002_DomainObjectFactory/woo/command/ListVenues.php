<?php
namespace woo\command;

require_once( "woo/domain/Venue.php" );

class ListVenues extends Command {
    function doExecute( \woo\controller\Request $request ) {
        $collection = \woo\domain\Venue::findAll();
        $request->setObject( 'venues', $collection );
        return self::statuses( 'CMD_OK' ); 
    }
}

?>
