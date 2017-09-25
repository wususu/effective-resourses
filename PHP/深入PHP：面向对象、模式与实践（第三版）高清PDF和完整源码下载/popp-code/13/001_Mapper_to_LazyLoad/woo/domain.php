<?php
$dir = "woo/domain/" ;
$dh = opendir( "$dir" );
while( $file = readdir( $dh ) ) {
    if ( substr( $file, -4 ) == ".php" ) {
        require_once( "$dir/$file" );
    }
}

?>
