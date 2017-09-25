<?php
namespace userthing\persist;

require_once("userthing/domain/User.php");

class UserStore {
    private $users = array();

    function addUser( $name, $mail, $pass ) {

        if ( isset( $this->users[$mail] ) ) {
            throw new \Exception(
                "User {$mail} already in the system");
        }

        $this->users[$mail] = new \userthing\domain\User( $name, $mail, $pass );
        return true;
    }

    function notifyPasswordFailure( $mail ) {
        if ( isset( $this->users[$mail] ) ) {
            $this->users[$mail]->failed(time());
        }
    }

    function getUser( $mail ) {
        if ( isset( $this->users[$mail] ) ) {
            return ( $this->users[$mail] );
        }
        return null;
    }
}
?>
