<?php
namespace woo\mapper;


class IdentityObject {

    private $columns = array();
    private static $types;

    const TYPE_EQ   = 1;
    const TYPE_L    = 2;
    const TYPE_LE   = 3;
    const TYPE_G    = 4;
    const TYPE_GE   = 5;
    const TYPE_LIKE = 6;

    protected function setColumn( $type, $name, $value ) {
        if ( self::typeExists( $type ) ) {
            $this->columns[$type][$name]=$value;
        } else {
            throw new Exception( "type: $type does not exist" );
        }
    }

    function getColumn( $type, $key ) {
        if ( ! isset($this->columns[$type]) ) {
            return null;
        }
        if ( isset( $this->columns[$type][$key] ) ) {
            $t = $this->columns[$type][$key];
            return $this->columns[$type][$key];
        }
        return null;
    }

    function getColumns( $type ) {
        if ( isset($this->columns[$type])) {
            return $this->columns[$type];    
        }
        return array();
    }

    static function types() {
        if ( isset( self::$types ) ) {
            return self::$types;
        }
        self::$types = array(   
                self::TYPE_EQ   => "=",
                self::TYPE_L    => "<",
                self::TYPE_LE   => "<=",
                self::TYPE_G    => ">",
                self::TYPE_GE   => ">=",
                self::TYPE_LIKE => "LIKE" );
        return self::$types;
    }

    static function typeExists( $type ) {
        $types = self::types();
        return ( isset( $types[$type] ) ); 
    }
}

?>
