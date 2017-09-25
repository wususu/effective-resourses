<?php
namespace woo\domain;

if ( ! isset( $EG_DISABLE_INCLUDES ) ) {
    require_once( "woo/mapper/VenueMapper.php" );
    require_once( "woo/mapper/SpaceMapper.php" );
    require_once( "woo/mapper/EventMapper.php" );
    require_once( "woo/mapper/Collections.php" );
}

class HelperFactory {
    static function getFinder( $type ) {
        $type = preg_replace( '|^.*\\\|', "", $type );
        $mapper = "\\woo\\mapper\\{$type}Mapper";
        if ( class_exists( $mapper ) ) {
            return new $mapper();
        }
        throw new \woo\base\AppException( "Unknown: $mapper" );
    }

    static function getCollection( $type ) {
        $type = preg_replace( '|^.*\\\|', "", $type );
        $collection = "\\woo\\mapper\\{$type}Collection";
        if ( class_exists( $collection ) ) {
            return new $collection();
        }
        throw new \woo\base\AppException( "Unknown: $collection" );
    }
}
?>
