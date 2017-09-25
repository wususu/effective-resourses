<?php
interface Chargeable {
    public function getPrice();
}

class ShopProduct implements Chargeable {
    // ...
    protected $price;
    // ...

    public function getPrice() {
        return $this->price;
    }
    // ...

}

$product = new ShopProduct();

?>
