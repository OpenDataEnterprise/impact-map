<?php
require_once('../simpletest/autorun.php');

class TestOfSimpleTest extends UnitTestCase {

	function testUnitTests() {
		$this->assertTrue(1==1);
		$this->assertFalse(1==2);
	}

}
?>