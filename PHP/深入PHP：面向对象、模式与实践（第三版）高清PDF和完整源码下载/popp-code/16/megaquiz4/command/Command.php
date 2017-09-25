<?php
/**
 * @license   http://www.example.com Borsetshire Open License
 * @package   command
 */

/**
 * Defines core functionality for commands.
 * Command classes perform specific tasks in a system via
 * the {@link execute()} method 
 *
 * @package command
 * @author  Clarrie Grundie
 * @copyright 2007 Ambridge Technologies Ltd
 */
abstract class Command {

/**
 * Perform the key operation encapsulated by the class.
 * Command classes encapsulate a single operation. They
 * are easy to add to and remove from a project, can be
 * stored after instantiation and invoked at
 * leisure.
 * @param  $context {@link CommandContext} Shared contextual data
 * @return bool     false on failure, true on success
 * @uses CommandContext
 * @link http://www.example.com More info
 */
    abstract function execute( CommandContext $context );
}


?>
