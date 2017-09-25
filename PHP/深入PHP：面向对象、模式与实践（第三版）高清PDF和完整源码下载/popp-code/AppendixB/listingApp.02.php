<?php
require( 'parse/MarkLogic.php' );

//$input      = '4';
//$statement = "( \$input equals '4' or  \$input equals 'four' )";
$input      = 'armpit';
$statement = "( \$input equals 'five' or \$input equals 'armpit')";

$engine = new MarkParse( $statement );
$result = $engine->evaluate( $input );
print "input: $input evaluating: $statement\n";
if ( $result ) {
    print "true!\n";
} else {
    print "false!\n";
}

?>
