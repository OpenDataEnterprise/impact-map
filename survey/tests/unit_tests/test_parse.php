<?php
require_once('../simpletest/autorun.php');
// require_once('../simpletest/web_tester.php');
SimpleTest::prefer(new TextReporter());

if (!file_exists('../../credentials.inc.php')) {
   echo "My credentials are missing!";
   exit;
}

require '../../credentials.inc.php';
// Include parse library
require ('../../vendor/parse.com-php-library_v1/parse.php');
// Include application functions
require ('../../functions.inc.php');

// Configuration
//-------------------------------
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
define("ERROR_LOG_FILE", "/tmp/php-error.log");
ini_set("error_log", ERROR_LOG_FILE);
date_default_timezone_set('America/New_York'); 

class TestOfSimpleTest extends UnitTestCase {

	function testUnitTests() {
		$this->assertTrue(1==1);
		$this->assertFalse(1==2);
	}

	function testLogToParse() {
		$ts = time();
		// Log request
		$event = "testLogToParse";
		$identifier = "0001234567";
		$identifier_class = "test";
		$summary = "Unit test at time: $ts";

		// Need to run a function to test storing data or do a mock.

		// $log_result = log_to_parse($event, $identifier, $identifier_class, $summary);
		// // {"createdAt":"2014-06-16T12:55:17.596Z","objectId":"1WqYGqB1VS"}
		// // echo "<pre>;".print_r($log_result)."</pre>";
		// $this->assertTrue($log_result['objectId']);
	}

}


?>