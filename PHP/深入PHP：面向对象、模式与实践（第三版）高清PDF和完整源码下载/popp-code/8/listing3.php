<?php
abstract class Lesson {
    private   $duration;
    private   $costStrategy;

    function __construct( $duration, CostStrategy $strategy ) {
        $this->duration = $duration;
        $this->costStrategy = $strategy;
    }

    function cost() {
        return $this->costStrategy->cost( $this );
    }

    function chargeType() {
        return $this->costStrategy->chargeType( );
    }

    function getDuration() {
        return $this->duration;
    }

    // more lesson methods...
}


abstract class CostStrategy {
    abstract function cost( Lesson $lesson );
    abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy {
    function cost( Lesson $lesson ) {
        return ( $lesson->getDuration() * 5 );
    }

    function chargeType() {
        return "hourly rate";
    }
}

class FixedCostStrategy extends CostStrategy {
    function cost( Lesson $lesson ) {
        return 30;
    }

    function chargeType() {
        return "fixed rate";
    }
}

class Lecture extends Lesson {
    // Lecture-specific implementations ...
}

class Seminar extends Lesson {
    // Seminar-specific implementations ...
}

class RegistrationMgr {
    function register( Lesson $lesson ) {
        // do something with this Lesson

        // now tell someone
        $notifier = Notifier::getNotifier();
        $notifier->inform( "new lesson: cost ({$lesson->cost()})" );
    }
}

abstract class Notifier {
    
    static function getNotifier() {
        // acquire concrete class according to 
        // configuration or other logic

        if ( rand(1,2) == 1 ) {
            return new MailNotifier();
        } else {
            return new TextNotifier();
        }
    }

    abstract function inform( $message );
}

class MailNotifier extends Notifier {
    function inform( $message ) {
        print "MAIL notification: {$message}\n";
    }
}

class TextNotifier extends Notifier {
    function inform( $message ) {
        print "TEXT notification: {$message}\n";
    }
} 
$lessons1 = new Seminar( 4, new TimedCostStrategy() );
$lessons2 = new Lecture( 4, new FixedCostStrategy() );
$mgr = new RegistrationMgr();
$mgr->register( $lessons1 );
$mgr->register( $lessons2 );

?>
