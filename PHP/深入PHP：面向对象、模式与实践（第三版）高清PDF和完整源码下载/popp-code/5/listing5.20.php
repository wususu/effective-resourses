<?php

class CdProduct {
    function __construct() { }
    function getPlayLength() { }
    function getSummaryLine() { }
    function getProducerFirstName() { }
    function getProducerMainName() { }
    function setDiscount() { }
    function getDiscount() { }
    function getTitle() { }
    function getPrice() { }
    function getProducer() { }
}

print_r( get_class_methods( 'CdProduct' ) );

?>
