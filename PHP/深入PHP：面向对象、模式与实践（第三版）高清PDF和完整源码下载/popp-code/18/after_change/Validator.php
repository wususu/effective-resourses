<?php
require_once "UserStore.php";

class Validator {
    private $store;
    public function __construct( UserStore $store ) {
        $this->store = $store;
    }

    public function validateUser( $mail, $pass ) {
        /*
        // this is the fix after tests fail 
        $user = $this->store->getUser( $mail );
        if ( is_null( $user ) ) {
            return null;
        }
        if ( $user->getPass() == $pass ) {
            return true;
        }
        $this->store->notifyPasswordFailure( $mail );
        return false;
        */
        if ( ! is_array($user = $this->store->getUser( $mail )) ) {
            return false;
        }
        if ( $user['pass'] == $pass ) {
            return true;
        }
        $this->store->notifyPasswordFailure( $mail );
        return false;
    }
}

?>
