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
	function testUnitTests() {

		$this->assertTrue(1==1);
		$this->assertFalse(1==2);
	}

	/*
	 * Test functions
	 */
	function testAddWbRegions() {

		$this->assertTrue(1==1);
		$un_loc_code = "AF";
		$wb_region = addWbRegions($un_loc_code);
		$this->assertTrue($wb_region['org_hq_country_region']=="South Asia");
		$this->assertTrue($wb_region['org_hq_country_income_code']=="LIC");

		$un_loc_code = "YE";
		$wb_region = addWbRegions($un_loc_code);
		$this->assertTrue($wb_region['org_hq_country_region']=="Middle East & North Africa");
		$this->assertTrue($wb_region['org_hq_country_income_code']=="LMC");
		// test non-existent code
		$un_loc_code = "Z0";
		$wb_region = addWbRegions($un_loc_code);
		
		$this->assertTrue(is_null($wb_region['org_hq_country_region']));
		$this->assertTrue(is_null($wb_region['org_hq_country_income_code']));
	}
}
?>