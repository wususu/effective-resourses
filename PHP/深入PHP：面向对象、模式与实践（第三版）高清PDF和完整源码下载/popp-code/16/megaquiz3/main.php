<?php
require_once("command/LoginCommand.php");
require_once("command/CommandContext.php");

$context = new CommandContext();
$context->addParam( "username", "bob" );
$context->addParam( "pass", "tiddles" );
$cmd = new LoginCommand( new AccessManager() );
if ( ! $cmd->execute( $context ) ) {
    print "an error occurred: ".$context->getError();
} else {
    print "successful login\n";
    $user_obj = $context->get( "user" );
}

?>
