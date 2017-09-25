<?php
class ShopProduct {
    public $title;
    public $producerMainName;
    public $producerFirstName;
    public $price = 0;

    function __construct( $title,
                          $firstName, $mainName, $price ) {
        $this->title             = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName  = $mainName;
        $this->price             = $price;
    }

    function getProducer() {
        return "{$this->producerFirstName}".
               " {$this->producerMainName}";
    }
}

$product1 = new ShopProduct( "My Antonia",
                             "Willa", "Cather", 5.99 );
print "author: {$product1->getProducer()}\n";
?>
