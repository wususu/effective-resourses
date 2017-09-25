<?php
class UserStore {
    private $users = array();

    function addUser( $name, $mail, $pass ) {

        if ( isset( $this->users[$mail] ) ) {
            throw new Exception(
                "User {$mail} already in the system");
        }

        if ( strlen( $pass ) < 5 ) {
            throw new Exception(
                "Password must have 5 or more letters");
        }

        $this->users[$mail] = array( 'pass' => $pass,
                                     'mail' => $mail,
                                     'name' => $name );
        return true;
    }

    function notifyPasswordFailure( $mail ) {
        if ( isset( $this->users[$mail] ) ) {
            $this->users[$mail]['failed']=time();
        }
    }

    function getUser( $mail ) {
        if ( isset( $this->users[$mail] ) ) {
            return ( $this->users[$mail] );
        }
        return null;
    }
}
/*
$store=new UserStore();
$store->addUser(  "bob williams",
                  "bob@example.com",
                  "12345" );
$user = $store->getUser(  "bob@example.com" );
print_r( $user );
$store->notifyPasswordFailure( "bob@example.com" );
*/
?>
