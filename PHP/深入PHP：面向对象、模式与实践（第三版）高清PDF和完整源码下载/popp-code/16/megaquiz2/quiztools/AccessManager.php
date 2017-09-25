<?php
/**
 * @package quiztools
 */
require_once("quizobjects/User.php");

class AccessManager {
    function login( $user, $pass ) {
        $ret = new User( $user );
        return $ret;
    }

    function getError() {
        return "move along now, nothing to see here";
    }
}

class ReceiverFactory {
    static function getAccessManager() {
        return new AccessManager();
    }
}

?>
