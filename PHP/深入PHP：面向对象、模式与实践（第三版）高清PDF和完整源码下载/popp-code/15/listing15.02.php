<?php

require_once("Config.php");

class MyConfig {
    private $rootObj;

    function __construct( $filename=null, $type='xml' ) {
        $this->type=$type;
        $conf = new Config();
        if ( ! is_null( $filename ) ) {
            //$filename = "notthere.conf";
            $this->rootObj = @$conf->parseConfig($filename, $type);
            if ( PEAR::isError( $this->rootObj ) ) {
                print "message:    ". $this->rootObj->getMessage()   ."\n";
                print "code:       ". $this->rootObj->getCode()      ."\n\n";
                print "Backtrace:\n";

                foreach ( $this->rootObj->getBacktrace() as $caller ) {
                    print_r( $caller );
                    print $caller['class'].$caller['type'];
                    print $caller['function']."() ";
                    print "line ".$caller['line']."\n";
                }
                die;
            }
            //print get_class( $this->rootObj )."\\\\ \n";;
        } else {
            $this->rootObj = new Config_Container( 'section', 'config' );
            $conf->setroot($this->rootObj);
        }
    }
    
    function set( $secname, $key, $val ) {
        $section=$this->getOrCreate( $this->rootObj, $secname );
        $directive=$this->getOrCreate( $section, $key, $val );
        $directive->setContent( $val );
    }

    function getOrCreate( Config_Container $cont, $name, $value=null ) {
        $itemtype=is_null( $value )?'section':'directive';
        if ( $child = $cont->searchPath( array($name) ) ) { 
            return $child;
        }
        return $cont->createItem( $itemtype, $name, null );
    }

    function __toString() {
        return $this->rootObj->toString( $this->type );
    }

    function get( $section, $key ) {
        $directive = $this->rootObj->searchPath( "config/$section/$key" );
        return $directive;
    }
}
$myconf = new MyConfig('test.broken.conf', 'inifile'); 
echo $myconf;
?>
