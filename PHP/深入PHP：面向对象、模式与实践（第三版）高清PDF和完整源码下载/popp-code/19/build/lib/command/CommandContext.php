<?php




class CommandContext {

    public $applicationName;


    private $params = array();


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
