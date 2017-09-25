<?php

class UnitException extends Exception {}

abstract class Unit {
    function getComposite() {
        return null;
    }

    abstract function bombardStrength();

    function textDump( $num=0 ) {
        $ret = "";
        $pad = 4*$num;
        $ret .= sprintf( "%{$pad}s", "" );
        $ret .= get_class($this).": ";
        $ret .= "bombard: ".$this->bombardStrength()."\n";
        return $ret;
    }

    function unitCount() {
        return 1;
    }
}

abstract class CompositeUnit extends Unit {
    private $units = array();

    function getComposite() {
        return $this;
    }

    function units() {
        return $this->units;
    }

    function removeUnit( Unit $unit ) {
        $units = array();
        foreach ( $this->units as $thisunit ) {
            if ( $unit !== $thisunit ) {
                $units[] = $thisunit;
            }
        }
        $this->units = $units;
    }

    function addUnit( Unit $unit ) {
        if ( in_array( $unit, $this->units, true ) ) {
            return;
        }
        $this->units[] = $unit;
    }

    function unitCount() {
        $ret = 0;
        foreach ( $this->units as $unit ) {
            $ret += $unit->unitCount(); 
        }
        return $ret;
    }

    function textDump( $num=0 ) {
        $ret = parent::textDump( $num );
        foreach ( $this->units as $unit ) {
            $ret .= $unit->textDump( $num + 1 ); 
        }
        return $ret;
    }

}


class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }
    function unitCount() {
        return 1;
    }
}

class Cavalry extends Unit {
    function bombardStrength() {
        return 2;
    }
}

class LaserCanonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}

class TroopCarrier extends CompositeUnit {

    function addUnit( Unit $unit ) {
        if ( $unit instanceof Cavalry ) {
            throw new UnitException("Can't get a horse on the vehicle");
        }
        parent::addUnit( $unit );
    }

    function bombardStrength() {
        return 0;
    }
}

// end previous code

class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach( $this->units() as $unit ) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

$main_army = new Army();
$main_army->addUnit( new Archer() );
$main_army->addUnit( new LaserCanonUnit() );
$sub_army=new Army();
$sub_army->addUnit( new Cavalry() );
$main_army->addUnit( $sub_army );
$main_army->addUnit( new Cavalry() );
print $main_army->textDump();
?>
