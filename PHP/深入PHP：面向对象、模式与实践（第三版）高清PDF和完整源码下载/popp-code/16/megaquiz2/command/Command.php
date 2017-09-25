<?php
/**
 * @package command
 */
abstract class Command {
    abstract function execute( CommandContext $context );
}


?>
