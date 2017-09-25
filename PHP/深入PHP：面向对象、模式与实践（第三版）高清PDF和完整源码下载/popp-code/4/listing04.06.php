<?php
require_once( "listing04.03.php" );

abstract class ShopProductWriter {
    protected $products = array();

    public function addProduct( ShopProduct $shopProduct ) {
        $this->products[]=$shopProduct;
    }

    abstract public function write( );
}

class ErroredWriter extends ShopProductWriter{
}

$writer = new ErroredWriter();
?>
