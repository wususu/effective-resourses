<?php
/*
 * Use this from PHP scripts, for a CLI implementation use
 * @bin_dir@/dialekt
 */

require_once("PEAR.php");
class Dialekt extends PEAR { 
    const DIALEKT_ALIG=1;
    const DIALEKT_DALEK=2;

    function __construct() {
        parent::PEAR();
    }

    public static function getDialekt( $int_dia ) {
        return PEAR::RaiseError( "bum",  444 );     
    }    
}

$ret = Dialekt::getDialekt(2);
if ( PEAR::isError( $ret ) ) {
    print "message:    ". $db->getMessage()   ."\n";
    print "code:       ". $db->getCode()      ."\n\n";
    print "Backtrace:\n";
    
    foreach ( $db->getBacktrace() as $caller ) {
        print $caller['class'].$caller['type'].$caller['function']."() ";
        print "line ".$caller['line']."\n";
    }
}
?>
