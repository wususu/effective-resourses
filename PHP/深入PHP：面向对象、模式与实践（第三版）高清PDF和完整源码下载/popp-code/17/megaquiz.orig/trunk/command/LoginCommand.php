<?php
/**
 * @license   http://www.example.com Borsetshire Open License
 * @package   command
 */

/**
 * includes
 */
require_once( "Command.php" );
require_once( "quiztools/AccessManager.php" );

/**
 * @package command
 */
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
