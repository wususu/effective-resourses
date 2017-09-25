<?php

require_once("XML/Feed/Parser.php");

//$source="./my.conf";
$source="notthere";

try {
    $myfeed = new XML_Feed_Parser( $source );

} catch ( XML_Feed_Parser_Exception $e ) {
    print "message: ".     $e->getMessage()      ."\n";
    print "code: ".        $e->getCode()         ."\n";
    print "error class: ". $e->getErrorClass()   ."\n";
    print "error method: ".$e->getErrorMethod()  ."\n";
    print "trace: ".       $e->getTraceAsString()."\n";
    print "error data: ";
    print_r(               $e->getErrorData() );
}
?>
