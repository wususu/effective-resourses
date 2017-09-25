<?php
namespace woo\command;

require_once( "woo/command/Command.php" );

class DefaultCommand2 extends Command {
    function doExecute( \woo\controller\Request $request ) {
        $request->addFeedback( "Welcome to WOO" );
    }
}

?>
