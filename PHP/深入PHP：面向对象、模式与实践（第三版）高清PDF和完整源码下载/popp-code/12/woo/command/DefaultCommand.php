<?php
namespace woo\command;

require_once( "woo/command/Command.php" );

class DefaultCommand extends Command {
    function doExecute( \woo\controller\Request $request ) {
        $request->addFeedback( "Welcome to WOO" );
    }
}

?>
