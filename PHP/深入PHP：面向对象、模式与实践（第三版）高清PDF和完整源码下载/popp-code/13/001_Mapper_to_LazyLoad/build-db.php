<?php
/*
 set up script for transaction script example
*/


class DBFace {
    private $pdo;
    function __construct( $dsn, $user=null, $pass=null ) {
        $this->pdo = new PDO( $dsn, $user, $pass );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    function query( $query ) {
        try {
            $stmt = $this->pdo->query( $query );
            return $stmt;
        } catch ( Exception $e ) {
            print $e->getMessage()."\n";
            return null;
        }
    }
}

//$mode="mysql";
$mode="sqlite";

if ( $mode == 'mysql' ) {
    $autoincrement = "AUTO_INCREMENT";
    $dsn = "mysql:dbname=test";    
} else {
//    $dsn = "sqlite:/".dirname(__FILE__)."/data/woo.db";    
    $dsn = "sqlite://tmp/data/woo.db";    
    $autoincrement = "AUTOINCREMENT";
}
$db=new DBFace($dsn);
$db->query( "DROP TABLE venue" );
$db->query( "CREATE TABLE venue ( id INTEGER PRIMARY KEY $autoincrement, name TEXT )" );

$db->query( "DROP TABLE space" );
$db->query( "CREATE TABLE space ( id INTEGER PRIMARY KEY $autoincrement, venue INTEGER, name TEXT )" ); 
$db->query( "DROP TABLE event" );
$db->query( "CREATE TABLE event ( id INTEGER PRIMARY KEY $autoincrement, space INTEGER, start long, duration int, name text )" );
?>
