<?php
namespace woo\command;

require_once( "woo/domain/Venue.php" );

class ListVenues extends Command {
    function doExecute( \woo\controller\Request $request ) {
        $collection = \woo\domain\Venue::findAll();
        $request->setObject( 'venues', $collection );

        $factory = \woo\mapper\PersistenceFactory::getFactory( 'woo\domain\Venue' );
        $finder = new \woo\mapper\DomainObjectAssembler( $factory );
        $idobj = $factory->getIdentityObject()->field('name')->eq('The Eyeball Inn');
        $collection = $finder->find( $idobj );
        foreach ( $collection as $venue ) {
            print_r( $venue );
        }
        
        return self::statuses( 'CMD_OK' ); 
    }
}

?>
