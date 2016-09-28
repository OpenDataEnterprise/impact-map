<?php
require_once('../simpletest/autorun.php');
require_once('../simpletest/web_tester.php');
require_once('utilities.php');

// Configuration
//-------------------------------
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
ini_set("error_log", "/tmp/php-error.log");
date_default_timezone_set('America/New_York'); 

class TestOfSurvey extends WebTestCase {

    function testSurveyStarts() {
        $this->get('http://'.$_SERVER['HTTP_HOST'].'/map/survey/start');
        $this->assertResponse(200);
        $this->assertTitle('Open Data Enterprise Survey');
        // $this->assertText('as publicly available Data');
        echo $this->getUrl();
    }

    function testBasicLogging() {
        $this->get('http://'.$_SERVER['HTTP_HOST'].'/map/survey/start');
        $this->assertResponse(200);

        echo "<br>should generate entry in /var/log/odesurvey/odesurvey.log<br>\n";
    }

    function testSurveySubmitComplete() {

        // Test getting getting blank survey page
    	$this->get('http://'.$_SERVER['HTTP_HOST'].'/map/survey/start');
        $this->assertResponse(200);
        
        // Fill in survey fields
        $this->setField("org_name", "SimpleTestCo");
        // Simpletest doesn't like input type url
    	// $this->setField("org_url", "http://www.simpletestco.com");
    	$this->setField("org_year_founded", "2004");
    	$this->setField("org_description", "This is a test description.");
    	$this->setField("org_additional", "This organization has a big impact...");
    	$this->setField("survey_contact_first", "Greg");
    	$this->setField("survey_contact_last", "Elin");
    	$this->setField("survey_contact_title", "Director of Surveys");
    	$this->setField("survey_contact_email", "greg@odesurvey.org");
    	$this->setField("survey_contact_phone", "505-555-1212");
		$this->setField("org_hq_city_all", "Chicago, IL, USA");

    	// spot check a couple survey fields
    	$this->assertField("org_year_founded", "2004");
    	$this->assertField('survey_contact_first', 'Greg');
    	// $this->assertField("org_url", "http://");
    	
    	// Add in parameter values for hidden fields that we cannot seem to set with 'setField'
    	$additional = array("org_hq_city"=>"Chicago", "org_hq_st_prov"=>"Illinois", "org_hq_country"=>"US", 
    		"latitude"=>"41.8781136", "longitude"=>"-87.62979819999998",
    		"org_size_id"=>"1 - 10", "org_type"=>"Other", "org_type_other"=>"Government",
    		"industry_id"=>"cul", "org_url"=>"http://www.simpletestco.com");
    	
        // SUBMIT SURVEY
        // NOTE: Form submits bypasses Javascript validation
    	$this->clickSubmitById( "btnSubmit", $additional );

        // Test thank you page appears
    	$this->assertResponse(200);
    	$this->assertTitle('Open Data Enterprise Survey - Thank You');

        // Get survey ID and test that survey cannot be re-completed

        $url_path = explode("/", parse_url($this->getUrl(), PHP_URL_PATH));
        $profile_id = $url_path[3];
        echo "<br>Submitted profile_id: $profile_id";

        // Test returning this submitted survey should take us to the submitted page instead of a blank survey
        $this->get('http://'.$_SERVER['HTTP_HOST'].'/map/survey/'.$profile_id);
        $this->assertResponse(200);
        $this->assertTitle('Open Data Enterprise Survey - Submitted');

    }

    // function testSurveyRawSubmit() {
    // 	$this->post(
    //             $this->get('http://'.$_SERVER['HTTP_HOST'].'/map/survey/2du/0000000000'),
    //             array('type' => 'superuser'));
    //     $this->assertNoText('user created');
    // }

}
?>
