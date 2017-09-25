<?php
require_once( "listing12.05.php" ); // Registry

// test file app registry
if ( ! isset( $argv[1] ) ) {
    // run script without argument to monitor
    while ( 1 ) {
        sleep(5);
        $thing = \woo\base\ApplicationRegistry::getDSN();

        \woo\base\RequestRegistry::instance();
        \woo\base\SessionRegistry::instance();
        \woo\base\MemApplicationRegistry::instance();

        print "dsn is {$thing}\n";
    }
} else {
    // run script with argument in separate window to change value.. see the result in monitor process
    print "setting dsn {$argv[1]}\n"; 
    \woo\base\ApplicationRegistry::setDSN($argv[1]);
}
