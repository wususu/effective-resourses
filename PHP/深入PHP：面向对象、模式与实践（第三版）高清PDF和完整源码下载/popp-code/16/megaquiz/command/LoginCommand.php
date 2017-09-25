<?php
require_once( "Command.php" );
require_once( "quiztools/AccessManager.php" );

class LoginCommand extends Command {

    function execute( CommandContext $context ) {
        $manager = ReceiverFactory::getAccessManager();
        $user = $context->get( 'username' );
        $pass = $context->get( 'pass' );
        $user = $manager->login( $user, $pass );
        if ( ! $user ) {
            $this->context->setError( $manager->getError() );
            return false;
        }
        $context->addParam( "user", $user );
        return true;
    }
}
?>
