<?php

    function workWithProducts( ShopProduct $prod ) {
        if ( $prod instanceof cdproduct ) {
            // do cd thing
            print "cd\n";
        } else if ( $prod instanceof bookproduct ) {
            // do book thing
            print "book\n";
        }
    }

class ShopProduct{}
class CdProduct extends ShopProduct {}
class BookProduct extends ShopProduct {}
workWithProducts( new CdProduct()  );
workWithProducts( new BookProduct() );

?>
