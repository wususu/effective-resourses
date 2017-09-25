<?php
class AddressManager {
    private $addresses = array( "209.131.36.159", "74.125.19.106" );

    function outputAddresses( $resolve ) {
        if ( is_string( $resolve ) ) {
           $resolve =
               ( preg_match("/false|no|off/i", $resolve ) )?
                 false:true;
        }

        foreach ( $this->addresses as $address ) {
            print $address;
            if ( $resolve ) {
                print " (".gethostbyaddr( $address ).")";
            }
            print "\n";
        }
    }
}

$settings = simplexml_load_file("listing.011.xml");
$manager = new AddressManager();
$manager->outputAddresses( (string)$settings->resolvedomains );
?>
