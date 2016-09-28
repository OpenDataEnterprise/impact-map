<?php
require_once('../simpletest/autorun.php');
require_once('utilities.php');

// Configuration
//-------------------------------
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
ini_set("error_log", "/tmp/php-error.log");
date_default_timezone_set('America/New_York'); 


class TestSlimBasic extends UnitTestCase {

	/*
	 * Test our SimpleTest is working
	 */
	function testUnitTests() {

		$this->assertTrue(1==1);
		$this->assertFalse(1==2);
	}

	function testStartSurvey() {

		$url = 'http://'.$_SERVER['HTTP_HOST'].'/survey/opendata/start';
		echo "$url</br>";
		$expected = "Hello, test!\n";
		$page = file_get_contents($url);
		$this->assertTrue($expected == $page);

	}

}

class TestOfAbout extends WebTestCase {
    function testOurAboutPageGivesFreeReignToOurEgo() {
        $this->get('http://test-server/index.php');
        $this->click('About');
        $this->assertTitle('About why we are so great');
        $this->assertText('We are really great');
    }
}
?>
