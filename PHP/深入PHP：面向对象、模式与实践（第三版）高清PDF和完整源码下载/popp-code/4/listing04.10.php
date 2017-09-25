<?php

abstract class DomainObject {

}

class User extends DomainObject {
    public static function create() {
        return new User();        
    }
}

class Document extends DomainObject {
    public static function create() {
        return new Document();        
    }
}

$document = Document::create();
print_r( $document );
?>
