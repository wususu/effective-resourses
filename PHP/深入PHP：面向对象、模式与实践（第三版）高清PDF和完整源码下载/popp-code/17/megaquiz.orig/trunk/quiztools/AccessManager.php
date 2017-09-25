<?php
/**
 * @license   http://www.example.com Borsetshire Open License
 * @package quiztools
 */

/**
 * includes
 */
require_once("quizobjects/User.php");

/**
 * @package quiztools
 */
class AccessManager {
    function login( $user, $pass ) {
        $ret = new User( $user );
        return $ret;
    }

    function getError() {
        return "move along now, nothing to see here";
    }
}

/**
 * @package quiztools
 */
class ReceiverFactory {
    static function getAccessManager() {
        return new AccessManager();
    }
}

?>
