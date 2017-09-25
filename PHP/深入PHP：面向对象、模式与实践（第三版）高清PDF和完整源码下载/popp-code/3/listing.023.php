<?php
class ShopProduct {
    private $title;
    private $discount = 0;
    private $producerMainName;
    private $producerFirstName;
    protected $price;

    function __construct(   $title, $firstName,
                            $mainName, $price ) {
        $this->title             = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName  = $mainName;
        $this->price             = $price;
    }

    function setDiscount( $num ) {
        $this->discount=$num;
    }

    function getPrice() {
        return ($this->price - $this->discount);
    }

    function getProducer() {
        return "{$this->producerFirstName}".
               " {$this->producerMainName}";
    }

    function getSummaryLine() {
        $base  = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        return $base;
    }
}

class CdProduct extends ShopProduct {
    public $playLength;

    function __construct(   $title, $firstName,
                            $mainName, $price, $playLength ) {
        parent::__construct(    $title, $firstName,
                                $mainName, $price );
        $this->playLength = $playLength;
    }

    function getPlayLength() {
        return $this->playLength;
    }

    function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": playing time - {$this->playLength}";
        return $base;
    }
}

class BookProduct extends ShopProduct {
    public $numPages;

    function __construct(   $title, $firstName,
                            $mainName, $price, $numPages ) {
        parent::__construct(    $title, $firstName,
                                $mainName, $price );
        $this->numPages = $numPages;
    }

    function getPrice() {
        return $this->price;
    }

    function getNumberOfPages() {
        return $this->numPages;
    }

    function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": page count - {$this->numPages}";
        return $base;
    }
}

$product1 = new CdProduct("cd1", "bob", "bobbleson", 4, 50 );
$product1->setDiscount( 3 );
print $product1->getSummaryLine();
print "\n";
print "price: {$product1->getPrice()}\n";

$product2 = new BookProduct("book1", "harry", "harrelson", 4, 30 );
$product2->setDiscount( 3 );
print $product2->getSummaryLine();
print "\n";
print "price: {$product2->getPrice()}\n";

?>
