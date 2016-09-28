<?php
require_once('../simpletest/autorun.php');
require_once('utilities.php');
require_once('../../functions.inc.php');


// Configuration
//-------------------------------
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
ini_set("error_log", "/tmp/php-error.log");
date_default_timezone_set('America/New_York'); 


class TestDataLog extends UnitTestCase {

	/*
	 * Test our SimpleTest is working
	 */
	function testDataLogWriting() {

// 		$this->assertTrue(1==1);
// 		$content = <<<EOC
// simple test of data log

// EOC;
// 		$result = writeDataLog($content);

// 		$this->assertTrue(writeDataLog($content));

		

	}

}

?>