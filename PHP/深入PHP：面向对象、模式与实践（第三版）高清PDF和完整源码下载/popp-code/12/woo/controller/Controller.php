<?php
namespace woo\controller;

require_once( "woo/base/Registry.php"); // using the real one now
require_once( "woo/controller/ApplicationHelper.php"); // using the real one now
require_once( "woo/controller/Request.php"); // using the real one now

class Controller {
    private $applicationHelper;

    private function __construct() {}

    static function run() {
        $instance = new Controller();
        $instance->init();
        $instance->handleRequest();
    }

    function init() {
        $applicationHelper
            = ApplicationHelper::instance();
        $applicationHelper->init();
    }

    function handleRequest() {
        $request = new Request();
        $app_c = \woo\base\ApplicationRegistry::appController();
        while( $cmd = $app_c->getCommand( $request ) ) {
            $cmd->execute( $request );
        }
        \woo\domain\ObjectWatcher::instance()->performOperations();
        $this->invokeView( $app_c->getView( $request ) );
    }

    function invokeView( $target ) {
        include( "woo/view/$target.php" );
        exit;
    }
}
Controller::run();
?>
