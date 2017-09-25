<?php
class ShopProduct {
    public $numPages;
    public $playLength;
    public $title;
    public $type;
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
        $this->type=( $numPages > 0 )?'book':'cd';
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

    function getSummaryLine() {
        $base  = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        if ( $this->type == 'book' ) {
            $base .= ": page count - {$this->numPages}";
        } else if ( $this->type == 'cd' ) {
            $base .= ": playing time - {$this->playLength}";
        }
        return $base;
    }

}

$product1 = new ShopProduct("cd1", "bob", "bobbleson", 4, null, 50 );
print $product1->getSummaryLine();
print "\n";
$product2 = new ShopProduct("book1", "harry", "harrelson", 4, 30 );
print $product2->getSummaryLine();
print "\n";
?>
