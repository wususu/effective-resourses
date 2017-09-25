<?php
function readParams( $source ) {
    $params = array();
    $fh = fopen( $source, 'r' ) or die("problem with $source");
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
    return $params;
}

function writeParams( $params, $source ) {
    $fh = fopen( $source, 'w' ) or die("problem with $source");
    foreach ( $params as $key=>$val ) {
        fputs( $fh, "$key:$val\n" );
    }
    fclose( $fh );
}


$file = "./params.txt"; 
$array['key1'] = "val1";
$array['key2'] = "val2";
$array['key3'] = "val3";
writeParams( $array, $file );
$output = readParams( $file );
print_r( $output ); 


?>
