<?php
namespace woo\process;

require_once( 'woo/base/Registry.php' );
require_once( 'woo/base/Exceptions.php' );

abstract class Base {
    static $DB;
    static $stmts = array();
   
    function __construct() {
        $dsn = \woo\base\ApplicationRegistry::getDSN( );
        if ( is_null( $dsn ) ) {
            throw new \woo\base\AppException( "No DSN" );
        }

        self::$DB = new \PDO( $dsn );
        self::$DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } 

    function prepareStatement( $stmt_s ) {
        if ( isset( self::$stmts[$stmt_s] ) ) {
            return self::$stmts[$stmt_s];
        }
        $stmt_handle = self::$DB->prepare($stmt_s);
        self::$stmts[$stmt_s]=$stmt_handle;
        return $stmt_handle;
    } 

    protected function doStatement( $stmt_s, $values_a ) {
        $sth = $this->prepareStatement( $stmt_s );
        $sth->closeCursor();
        $db_result = $sth->execute( $values_a );
        return $sth;
    }
}


class VenueBooker {
}

class VenueManager extends Base {
    static $add_venue =  "INSERT INTO venue 
                          ( name ) 
                          values( ? )";
    static $add_space  = "INSERT INTO space
                          ( name, venue ) 
                          values( ?, ? )"; 
    static $check_slot = "SELECT id, name 
                          FROM event 
                          WHERE space = ? 
                          AND (start+duration) > ? 
                          AND start < ?"; 
    static $add_event =  "INSERT INTO event 
                          ( name, space, start, duration ) 
                          values( ?, ?, ?, ? )"; 

    function addVenue( $name, $space_array ) {
        $ret = array();
        $ret['venue'] = array( $name ); 
        $this->doStatement( self::$add_venue, $ret['venue']);
        $v_id = self::$DB->lastInsertId();
        $ret['spaces'] = array();
        foreach ( $space_array as $space_name ) {
            $values = array( $space_name, $v_id );
            $this->doStatement( self::$add_space, $values);
            $s_id = self::$DB->lastInsertId();
            array_unshift( $values, $s_id );
            $ret['spaces'][] = $values;
        }
        return $ret;
    }
    
    function bookEvent( $space_id, $name, $time, $duration ) {
        $values = array( $space_id, $time, ($time+$duration) ); 
        $stmt = $this->doStatement( self::$check_slot, $values, false ) ;
        if ( $result = $stmt->fetch() ) {
            throw new \woo\base\AppException( "double booked! try again" );
        }
        $this->doStatement( self::$add_event, 
            array( $name, $space_id, $time, $duration ) );
    } 

}
$halfhour = (60*30);
$hour     = (60*60);
$day      = (24*$hour);

//$mode="mysql";
$mode="sqlite";

if ( $mode == 'mysql' ) {
    $dsn = "mysql:dbname=test";    
} else {
    $dsn = "sqlite://tmp/data/woo.db";    
}

\woo\base\ApplicationRegistry::setDSN( $dsn ); 
$mgr = new VenueManager();
$ret = $mgr->addVenue( "The Eyeball Inn", 
                array( 'The Room Upstairs', 'Main Bar' ));
$space_id = $ret['spaces'][0][0];
$mgr->bookEvent( $space_id, "Running like the rain", time()+($day), ($hour-5) ); 
$mgr->bookEvent( $space_id, "Running like the trees", time()+($day-$hour), (60*60) ); 

?>
