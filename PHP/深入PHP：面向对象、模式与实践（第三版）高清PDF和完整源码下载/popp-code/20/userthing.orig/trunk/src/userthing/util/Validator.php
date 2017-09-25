<?php
namespace userthing\util;

require_once "userthing/persist/UserStore.php";

class Validator {
    private $store;
    public function __construct( \userthing\persist\UserStore $store ) {
        $this->store = $store;
    }

    public function validateUser( $mail, $pass ) {
        $user = $this->store->getUser( $mail );
        if ( is_null( $user ) ) {
            return null;
        }
        if ( $user->getPass() == $pass ) {
            return true;
        }
        $this->store->notifyPasswordFailure( $mail );
        return false;
    }
}

?>
