<?php
require_once( "listing04.03.php" );

abstract class ShopProductWriter {
    protected $products = array();

    public function addProduct( ShopProduct $shopProduct ) {
        $this->products[]=$shopProduct;
    }

    abstract public function write( );
}

class XmlProductWriter extends ShopProductWriter{
    public function write() {
        $str = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $str .= "<products>\n";
         foreach ( $this->products as $shopProduct ) {
            $str .= "\t<product title=\"{$shopProduct->getTitle()}\">\n";
            $str .= "\t\t<summary>\n";
            $str .= "\t\t{$shopProduct->getSummaryLine()}\n";
            $str .= "\t\t</summary>\n";
            $str .= "\t</product>\n";
        }
        $str .= "</products>\n";   
        print $str;
    }
}

class TextProductWriter extends ShopProductWriter{
    public function write() {
        $str = "PRODUCTS:\n";
        foreach ( $this->products as $shopProduct ) {
            $str .= $shopProduct->getSummaryLine()."\n";
        }
        print $str;
    }
}

$product1 = new BookProduct(    "My Antonia", "Willa", "Cather", 5.99, 300 );
$product2 =   new CdProduct(    "Exile on Coldharbour Lane", 
                                "The", "Alabama 3", 10.99, 60.33 );

$textwriter = new TextProductWriter();
$textwriter->addProduct( $product1 );
$textwriter->addProduct( $product2 );
$textwriter->write();

$xmlwriter = new XmlProductWriter();
$xmlwriter->addProduct( $product1 );
$xmlwriter->addProduct( $product2 );
$xmlwriter->write();
?>
