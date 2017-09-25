<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://localhost/webwoo/");
  }

  function testMyTestCase()
  {
    $this->open("/webwoo/?cmd=AddVenue");
    try {
        $this->assertTrue($this->isTextPresent("no name provided"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    $this->type("venue_name", "my_test_venue");
    $this->click("//input[@value='submit']");
    $this->waitForPageToLoad("30000");
    try {
        $this->assertTrue($this->isTextPresent("'my_test_venue' added"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    $this->type("space_name", "my_test_space");
    $this->click("//input[@value='submit']");
    $this->waitForPageToLoad("30000");
    try {
        $this->assertTrue($this->isTextPresent("space 'my_test_space' added"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
  }
}
?>