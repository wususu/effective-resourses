<?php
abstract class Unit {
    abstract function addUnit( Unit $unit );
    abstract function removeUnit( Unit $unit );
    abstract function bombardStrength();
}
class Army extends Unit {
    private $units = array();

    function addUnit( Unit $unit ) {
        if ( in_array( $unit, $this->units, true ) ) {
            return;
        }
        
        $this->units[] = $unit;
    }

    function removeUnit( Unit $unit ) {
        // >= php 5.3
        //$this->units = array_udiff( $this->units, array( $unit ), 
        //                function( $a, $b ) { return ($a === $b)?0:1; } );

        // < php 5.3
        $this->units = array_udiff( $this->units, array( $unit ), 
                        create_function( '$a,$b', 'return ($a === $b)?0:1;' ) );
    }

    function bombardStrength() {
        $ret = 0;
        foreach( $this->units as $unit ) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

// quick example classes
class Tank extends Unit { 
    function addUnit( Unit $unit ) {}
    function removeUnit( Unit $unit ) {}

    function bombardStrength() {
        return 4;
    }
}

class Soldier extends Unit { 
    function addUnit( Unit $unit ) {}
    function removeUnit( Unit $unit ) {}

    function bombardStrength() {
        return 8;
    }
}

$tank =  new Tank();
$tank2 = new Tank();
$soldier = new Soldier();

$army = new Army();
$army->addUnit( $soldier );
$army->addUnit( $tank );
$army->addUnit( $tank2 );

print_r( $army );

$army->removeUnit( $tank2 );

print_r( $army );
?>
