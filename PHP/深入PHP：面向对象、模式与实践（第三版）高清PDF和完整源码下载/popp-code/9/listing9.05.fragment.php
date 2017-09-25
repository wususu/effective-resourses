<?php

abstract class Preferences {
    private $props = array();
    private static $mockmode = false;
    private static $instance=null;

    private function __construct() { }

    public static function mockmode( $which=true ) {
        self::$mockmode = $which;
        self::$instance=null;
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = (self::$mockmode)? 
                        new PreferencesMock():
                        new PreferencesImpl();
        }
        return self::$instance;
    }

    public abstract function getDsn();

    // ...
}

class PreferencesImpl {
    public function getDsn() {
        return "** real DSN\n";
    }
}

class PreferencesMock {
    public function getDsn() {
        return "** test DSN\n";
    }
}

$pref = Preferences::getInstance();
print $pref->getDsn();

Preferences::mockmode();
$pref = Preferences::getInstance();

print $pref->getDsn();
?>
