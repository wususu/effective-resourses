<?php

interface Observable {
    function attach( Observer $observer );
    function detach( Observer $observer );
    function notify();
}

interface Observer {
    function update( Observable $observable );
}

class Login implements Observable {
    private $observers;
    private $storage;
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS   = 2;
    const LOGIN_ACCESS       = 3;

    function __construct() {
        $this->observers = array();
    }

    function attach( Observer $observer ) {
        $this->observers[] = $observer;
    }

    function detach( Observer $observer ) {
        // >= php 5.3
        //$this->observers = array_udiff( $this->observers, array( $observer ), 
        //                function( $a, $b ) { return ($a === $b)?0:1; } );

        // < php 5.3
        $this->observers = array_udiff( $this->observers, array( $observer ), 
                        create_function( '$a,$b', 'return ($a === $b)?0:1;') );
    }

    function notify() {
        foreach ( $this->observers as $obs ) {
            $obs->update( $this );
        }
    }

    function handleLogin( $user, $pass, $ip ) {
        switch ( rand(1,3) ) {
            case 1: 
                $this->setStatus( self::LOGIN_ACCESS, $user, $ip );
                $ret = true; break;
            case 2:
                $this->setStatus( self::LOGIN_WRONG_PASS, $user, $ip );
                $ret = false; break;
            case 3:
                $this->setStatus( self::LOGIN_USER_UNKNOWN, $user, $ip );
                $ret = false; break;
        }
        $this->notify();
        return $ret;
    }

    private function setStatus( $status, $user, $ip ) {
        $this->status = array( $status, $user, $ip ); 
    }

    function getStatus() {
        return $this->status;
    }
}

abstract class LoginObserver implements Observer {
    private $login;
    function __construct( Login $login ) {
        $this->login = $login; 
        $login->attach( $this );
    }

    function update( Observable $observable) {
        if ( $observable === $this->login ) {
            $this->doUpdate( $observable );
        }
    }

    abstract function doUpdate( Login $login );
} 

class SecurityMonitor extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus(); 
        if ( $status[0] == Login::LOGIN_WRONG_PASS ) {
            // send mail to sysadmin 
            print __CLASS__.":\tsending mail to sysadmin\n"; 
        }
    }
}

class GeneralLogger  extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus(); 
        // add login data to log
        print __CLASS__.":\tadd login data to log\n"; 
    }
}

class PartnershipTool extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus(); 
        // check $ip address 
        // set cookie if it matches a list
        print __CLASS__.":\tset cookie if it matches a list\n"; 
    }
}

$login = new Login();
new SecurityMonitor( $login );
new GeneralLogger( $login );
$pt = new PartnershipTool( $login );
$login->detach( $pt );
for ( $x=0; $x<10; $x++ ) {
    $login->handleLogin( "bob","mypass", '158.152.55.35' );
    print "\n";
}

?>
