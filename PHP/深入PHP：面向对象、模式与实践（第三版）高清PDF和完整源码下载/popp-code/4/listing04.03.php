<?php
class ShopProduct {
    private $title;
    private $producerMainName;
    private $producerFirstName;
    protected $price;
    private $discount = 0; 
    private $id = 0;
    
    public function __construct(   $title, $firstName, 
                            $mainName, $price ) { 
        $this->title             = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName  = $mainName;
        $this->price             = $price;
    }

    public function setID( $id ) {
        $this->id = $id;
    }

    public function getProducerFirstName() {
        return $this->producerFirstName;
    }

    public function getProducerMainName() {
        return $this->producerMainName;
    }

    public function setDiscount( $num ) {
        $this->discount=$num;
    }

    public function getDiscount() {
        return $this->discount;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function getPrice() {
        return ($this->price - $this->discount);
    }

    public function getProducer() {
        return "{$this->producerFirstName}".
               " {$this->producerMainName}";
    }

    function getSummaryLine() {
        $base  = "$this->title ( $this->producerMainName, ";
        $base .= "$this->producerFirstName )"; 
        return $base;
    }

    public static function getInstance( $id, PDO $pdo ) {
        $query = "select * from products where id='$id'";
        $stmt = $pdo->prepare("select * from products where id=?");
        $result = $stmt->execute( array( $id ) );
        $row = $stmt->fetch( );
        if ( empty( $row ) ) { return null; }

        if ( $row['type'] == "book" ) {
            $product = new BookProduct( 
                                    $row['title'], 
                                    $row['firstname'], $row['mainname'], 
                                    $row['price'], $row['numpages'] ); 
        } else if ( $row['type'] == "cd" ) {
            $product = new CdProduct(
                                    $row['title'], 
                                    $row['firstname'], $row['mainname'], 
                                    $row['price'], $row['playlength'] ); 
        } else {
            $product = new ShopProduct(     
                                    $row['title'], 
                                    $row['firstname'], $row['mainname'], 
                                    $row['price'] ); 
        }
        $product->setId(            $row['id'] );
        $product->setDiscount(      $row['discount'] );
        return $product;
    }
}

class CdProduct extends ShopProduct {
    private $playLength = 0;

    public function __construct(   $title, $firstName, 
                            $mainName, $price, $playLength ) { 
        parent::__construct(    $title, $firstName, 
                                $mainName, $price );
        $this->playLength = $playLength;
    }

    public function getPlayLength() {
        return $this->playLength;
    }

    function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": playing time - $this->playLength";
        return $base;
    }
 
}

class BookProduct extends ShopProduct {
    private $numPages = 0;

    public function __construct(   $title, $firstName, 
                            $mainName, $price, $numPages ) { 
        parent::__construct(    $title, $firstName, 
                                $mainName, $price );
        $this->numPages = $numPages;
    }

    public function getNumberOfPages() {
        return $this->numPages;
    }
   
    function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": page count - $this->numPages";
        return $base;
    }

    public function getPrice() {
        return $this->price;
    }
}

require_once("generate_product_pdo.php");
$pdo = getPDO();
$obj = ShopProduct::getInstance( 1, $pdo );
print_r( $obj );
$obj = ShopProduct::getInstance( 2, $pdo );
print_r( $obj );
$obj = ShopProduct::getInstance( 3, $pdo );
print_r( $obj );
?>
