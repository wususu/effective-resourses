<?php

class Person {
    function getName()  { return "Bob"; }
    function getAge() { return 44; }
    function __toString() {
        $desc  = $this->getName()." (age ";
        $desc .= $this->getAge().")";
        return $desc;
    }
}

$person = new Person();
print $person;
// Bob (age 44)
?>
