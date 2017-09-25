<?php

$file = "./texttest.proc.xml"; 
$array['key1'] = "val1";
$array['key2'] = "val2";
$array['key3'] = "val3";
writeParams( $array, $file );
$output = readParams( $file );
print_r( $output ); 

function readParams( $source ) {
    $params = array();
    if ( preg_match( "/\.xml$/i", $source )) {
        $el = simplexml_load_file( $source ); 
        foreach ( $el->param as $param ) {
            $params["$param->key"] = "$param->val";
        }
    } else {
        $fh = fopen( $source, 'r' );
        while ( ! feof( $fh ) ) {
            $line = trim( fgets( $fh ) );
            if ( ! preg_match( "/:/", $line ) ) {
                continue;
            }
            list( $key, $val ) = explode( ':', $line );
            if ( ! empty( $key ) ) {
                $params[$key]=$val;
            }
        }
        fclose( $fh );
    }
    return $params;
}

function writeParams( $params, $source ) {
    $fh = fopen( $source, 'w' );
    if ( preg_match( "/\.xml$/i", $source )) {
        fputs( $fh, "<params>\n" );
        foreach ( $params as $key=>$val ) {
            fputs( $fh, "\t<param>\n" );
            fputs( $fh, "\t\t<key>$key</key>\n" );
            fputs( $fh, "\t\t<val>$val</val>\n" );
            fputs( $fh, "\t</param>\n" );
        }
        fputs( $fh, "</params>\n" );
    } else {
        foreach ( $params as $key=>$val ) {
            fputs( $fh, "$key:$val\n" );
        }
    }
    fclose( $fh );
}
?>
