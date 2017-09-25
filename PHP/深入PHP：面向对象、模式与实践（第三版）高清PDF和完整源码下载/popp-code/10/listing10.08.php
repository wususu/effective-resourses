<?php

class UnitException extends Exception {}

abstract class Unit {
    function getComposite() {
        return null;
    }

    abstract function bombardStrength();
}


abstract class CompositeUnit extends Unit {
    private $units = array();

    function getComposite() {
        return $this;
    }

    protected function units() {
        return $this->units;
    }

    function removeUnit( Unit $unit ) {
        // >= php 5.3
        //$this->units = array_udiff( $this->units, array( $unit ), 
        //                function( $a, $b ) { return ($a === $b)?0:1; } );

        // < php 5.3
        $this->units = array_udiff( $this->units, array( $unit ), 
                        create_function( '$a,$b', 'return ($a === $b)?0:1;' ) );
    }

    function addUnit( Unit $unit ) {
        if ( in_array( $unit, $this->units, true ) ) {
            return;
        }
        $this->units[] = $unit;
    }
}
class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach( $this->units as $unit ) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }

}

class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }
}

class LaserCannonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}

class Cavalry extends Unit {
    function bombardStrength() {
        return 33;
    }
}

class TroopCarrier {

    function addUnit( Unit $unit ) {
        if ( $unit instanceof Cavalry ) {
            throw new UnitException("Can't get a horse on the vehicle");
        }
        super::addUnit( $unit );
    }

    function bombardStrength() {
        return 0;
    }
}


$tc= new TroopCarrier();
$ca= new Cavalry();

$tc->addUnit( $ca ) ;
?>
