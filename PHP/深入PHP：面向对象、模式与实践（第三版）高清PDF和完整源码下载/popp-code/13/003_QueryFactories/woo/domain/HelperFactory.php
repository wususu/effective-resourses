<?php
namespace woo\domain;

if ( ! isset( $EG_DISABLE_INCLUDES ) ) {
    require_once( "woo/mapper/VenueMapper.php" );
    require_once( "woo/mapper/SpaceMapper.php" );
    require_once( "woo/mapper/EventMapper.php" );
    require_once( "woo/mapper/Collections.php" );
}
require_once( "woo/mapper/DomainObjectAssembler.php" );

class HelperFactory {
    static function getFinder( $type ) {
        $factory = \woo\mapper\PersistenceFactory::getFactory( $type );
        return new \woo\mapper\DomainObjectAssembler( $factory );
    }

    static function getCollection( $type, array $array ) {
        $factory = \woo\mapper\PersistenceFactory::getFactory( $type );
        return $factory->getCollection( $array );
    }

}
?>
