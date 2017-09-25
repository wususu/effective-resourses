<?php
class TimedService{ }
interface Bookable{ }
interface Chargeable{ }

class Consultancy extends TimedService implements Bookable, Chargeable {
    // ...
}
?>
