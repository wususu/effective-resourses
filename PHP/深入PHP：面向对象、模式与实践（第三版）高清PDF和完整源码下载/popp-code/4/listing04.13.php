<?php
abstract class DomainObject {
    private $group;
    public function __construct() {
        $this->group = static::getGroup();
    }

    public static function create() {
        return new static();        
    }

    static function getGroup() {
        return "default"; 
    }
}

class User extends DomainObject {
}

class Document extends DomainObject {
    static function getGroup() {
        return "document"; 
    }
}

class SpreadSheet extends Document {
}

print_r(User::create());
print_r(SpreadSheet::create());
?>
