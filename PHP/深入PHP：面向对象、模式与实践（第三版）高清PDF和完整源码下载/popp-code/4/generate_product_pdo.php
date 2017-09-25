<?php

function getPDO() {
    $create_products = "CREATE TABLE products ( 
                            id INTEGER PRIMARY KEY AUTOINCREMENT, 
                            type TEXT,
                            firstname TEXT,
                            mainname TEXT,
                            title TEXT,
                            price float,
                            numpages int,
                            playlength int,
                            discount int )";
    $dsn = "sqlite:/".dirname(__FILE__)."/products.db";    
    $pdo = new PDO( $dsn, null, null );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt= $pdo->query( "select count(*) from SQLITE_MASTER" );
    $row = $stmt->fetch( );
    $stmt->closeCursor();
    if ( $row[0] > 0 ) {
        $pdo->query( "DROP TABLE products" );
    }
    $pdo->query( $create_products );
    $pdo->query( "INSERT INTO products ( type, firstname, mainname, title, price, numpages, playlength, discount ) 
                                values ( 'book', 'willa', 'cather', 'my antonia', 4.22, 200, NULL, 0 )");
    $pdo->query( "INSERT INTO products ( type, firstname, mainname, title, price, numpages, playlength, discount ) 
                                values ( 'cd', 'the', 'clash', 'london calling', 4.22, 200, 60, 0 )");
    $pdo->query( "INSERT INTO products ( type, firstname, mainname, title, price, numpages, playlength, discount ) 
                                values ( 'shop', NULL, 'pears', 'soap', 4.22, NULL, NULL, 0 )");
    return $pdo;
}
?>
