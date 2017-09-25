<?php
class Checkout {
    final function totalize() {
        // calculate bill
    }
}


class IllegalCheckout extends Checkout {
    final function totalize() {
        // change bill calculation
    }
}

$checkout = new Checkout();

?>
