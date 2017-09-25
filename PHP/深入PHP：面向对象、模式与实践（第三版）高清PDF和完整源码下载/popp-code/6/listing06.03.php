<?php
abstract class ParamHandler {
    protected $source;
    protected $params = array();

    function __construct( $source ) {
        $this->source = $source;
    }

    function addParam( $key, $val ) {
        $this->params[$key] = $val;
    }

    function getAllParams() {
        return $this->params;
    }

    protected function openSource( $flag ) {
        $fh = @fopen( $this->source, $flag );
        if ( empty( $fh ) ) {
            throw new Exception( "could not open: $this->source!" );
        }
        return $fh;
    }

    static function getInstance( $filename ) {
        if ( preg_match( "/\.xml$/i", $filename )) {
            return new XmlParamHandler( $filename );
        }
        return new TextParamHandler( $filename );
    }

    abstract function write();
    abstract function read();
}

class XmlParamHandler extends ParamHandler {

    function write() {
        $fh = $this->openSource('w');
        fputs( $fh, "<params>\n" );
        foreach ( $this->params as $key=>$val ) {
            fputs( $fh, "\t<param>\n" );
            fputs( $fh, "\t\t<key>$key</key>\n" );
            fputs( $fh, "\t\t<val>$val</val>\n" );
            fputs( $fh, "\t</param>\n" );
        }
        fputs( $fh, "</params>\n" );
        fclose( $fh );
        return true;
    }

    function read() {
        $el = @simplexml_load_file( $this->source ); 
        if ( empty( $el ) ) { 
            throw new Exception( "could not parse $this->source" );
        } 
        foreach ( $el->param as $param ) {
            $this->params["$param->key"] = "$param->val";
        }
        return true;
    } 

}

class TextParamHandler extends ParamHandler {

    function write() {
        $fh = $this->openSource('w');
        foreach ( $this->params as $key=>$val ) {
            fputs( $fh, "$key:$val\n" );
        }
        fclose( $fh );
        return true;
    }

    function read() {
        $lines = file( $this->source );
        foreach ( $lines as $line ) {
            $line = trim( $line );
            list( $key, $val ) = explode( ':', $line );
            $this->params[$key]=$val;
        }
        return true;
    } 

}

//$file = "./texttest.xml"; 
$file = "./texttest.txt"; 
$test = ParamHandler::getInstance( $file );
$test->addParam("key1", "val1" );
$test->addParam("key2", "val2" );
$test->addParam("key3", "val3" );
$test->write();

$test = ParamHandler::getInstance( $file );
$test->read();

$arr = $test->getAllParams();
print_r( $arr );
?>
