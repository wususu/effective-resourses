<?php
/**
 * @license   http://www.example.com Borsetshire Open License
 * @package   command
 */

/**
 * Encapsulates data for passing to, from and between Commands.
 * Commands require disparate data according to context. The
 * CommandContext object is passed to the {@link Command::execute()}
 * method, and contains data in key/value format. The class
 * automatically extracts the contents of the $_REQUEST 
 * superglobal.
 *
 * @package command
 * @author  Clarrie Grundie
 * @copyright 2007 Ambridge Technologies Ltd
 */

class CommandContext {
/**
 * The application name.
 * Used by various clients for error messages, etc.
 * @var string
 */
    public $applicationName;

/**
 * Encapsulated Keys/values.
 * This class is essentially a wrapper for this array
 * @var array
 */
    private $params = array();

/**
 * An error message.
 * @var string
 */
    private $error = "";

    function __construct( $appname ) {
        $this->params = $_REQUEST;
        $this->applicationName = $appname;
    }

    function addParam( $key, $val ) { 
        $this->params[$key]=$val;
    }

    function get( $key ) { 
        return $this->params[$key];
    }

    function setError( $error ) {
        $this->error = $error;
    }

    function getError() {
        return $this->error;
    }
}

?>
