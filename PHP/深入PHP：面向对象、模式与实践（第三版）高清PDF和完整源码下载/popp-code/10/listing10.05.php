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

class UnitException extends Exception {}

class Archer extends Unit {
    function addUnit( Unit $unit ) {
        throw new UnitException( get_class($this)." is a leaf" );
    }

    function removeUnit( Unit $unit ) {
        throw new UnitException( get_class($this)." is a leaf" );
    }

    function bombardStrength() {
        return 4;
    }
}

$archer = new Archer();
$archer2 = new Archer();
$archer->addUnit( $archer2 );

?>
