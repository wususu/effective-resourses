<?php
class CdProduct {}

function getProduct() {
    return new CdProduct(    "Exile on Coldharbour Lane",
                                "The", "Alabama 3", 10.99, 60.33 );
}

$product = getProduct();
if ( $product ) instanceof CdProduct ) {
    print "\$product is a CdProduct object\n";
}

?>
