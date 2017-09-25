<?php
class ShopProduct {
    public $numPages;
    public $playLength;
    public $title;
    public $producerMainName;
    public $producerFirstName;
    public $price;

    function __construct(   $title, $firstName,
                            $mainName, $price,
                            $numPages=0, $playLength=0 ) {
        $this->title             = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName  = $mainName;
        $this->price             = $price;
        $this->numPages          = $numPages;
        $this->playLength        = $playLength;
    }

    function getNumberOfPages() {
        return $this->numPages;
    }

    function getPlayLength() {
        return $this->playLength;
    }

    function getProducer() {
        return "{$this->producerFirstName}".
               " {$this->producerMainName}";
    }
}

$product1 = new ShopProduct("cd1", "bob", "bobbleson", 4, null, 50 );
print $product1->getPlayLength();
print $product1->getProducer();
print "\n";
$product2 = new ShopProduct("book1", "harry", "harrelson", 4, 30 );
print $product2->getNumberOfPages();
print $product2->getProducer();
print "\n";
?>
