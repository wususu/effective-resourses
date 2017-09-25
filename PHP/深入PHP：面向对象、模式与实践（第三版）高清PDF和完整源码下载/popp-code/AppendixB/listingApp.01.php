<?php
require_once("gi/parse/Scanner.php");
require_once("gi/parse/Context.php");
require_once("gi/parse/StringReader.php");

$context = new \gi\parse\Context();
$user_in = "\$input equals '4' or \$input equals 'four'";
$reader = new \gi\parse\StringReader( $user_in );
$scanner = new \gi\parse\Scanner( $reader, $context );

while ( $scanner->nextToken() != \gi\parse\Scanner::EOF ) {
    print $scanner->token();
    print "\t{$scanner->char_no()}";
    print "\t{$scanner->getTypeString()}\n";
}
?>
