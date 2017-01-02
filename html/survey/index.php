<?php
// Expand memory being used by PHP
ini_set('memory_limit','400M');
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
session_start();
$now = time();
// echo "discard after: $now<br>";
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}
// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 3600;
// echo "<pre>top of script\n"; print_r($_SESSION);
// Configuration
//-------------------------------
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
define("ERROR_LOG_FILE", "/tmp/php-error.log");
ini_set("error_log", ERROR_LOG_FILE);
date_default_timezone_set('America/New_York'); 
if (!file_exists('credentials.inc.php')) {
   echo "My credentials are missing!";
   exit;
}
// make sure log directory exists and is owned by apache
define("ODESURVEY_LOG", "/var/log/odesurvey/odesurvey.log");
if (!file_exists(ODESURVEY_LOG)) {
	echo "My log file directory ".ODESURVEY_LOG." is missing!";
	exit;
}
$fileinfo = posix_getpwuid(fileowner(ODESURVEY_LOG));
if ($fileinfo['name'] != "apache" && $fileinfo['name'] != "www-data") {
	echo $fileinfo['name'];
	echo "My log file ".ODESURVEY_LOG." is is not owned by Apache!";
	exit;
} 
// Set if sending email is on
define("SEND_MAIL", false);
// Include libraries added with composer
require 'vendor/autoload.php';
// Include credentials
require 'credentials.inc.php';
// Include parse library
require ('vendor/parse.com-php-library_v1/parse.php');
// Include application functions
require 'functions.inc.php';
// Use Mailgun
use Mailgun\Mailgun;
# Use Amazon Web Services Ec2 SDK to interact with EC2 instances
# use Aws\Ec2\Ec2Client;
 
// Functions
//-------------------------------
function TempLogger($message) {
	error_log( "Logger $message" );
}
// Set up basic logging using slim built in logger
// NOTE: Makes sure /var/log/odesurvey/ directory exists and owned by apache:apache
$logWriter = new \Slim\LogWriter(fopen(ODESURVEY_LOG, 'a'));
// Start Slim instance
//-------------------------------
$app = new \Slim\Slim(array('log.writer' => $logWriter));
// Handle not found
$app->notFound(function () use ($app) {
	// Temporarily route /map, /viz to /map.html
	$actual_link = "$_SERVER[REQUEST_URI]";
	if ("/index.html" == "$actual_link" || "/viz/index.html" == "$actual_link") {
		$app->redirect("/map.html");
	}
	// Let's make sure we remove a trailing "/" on any not found paths
        $actual_link = rtrim($actual_link, '/');
        
	// Any change to below array must also be made to identical array in route "/" around line 210
	if (in_array($actual_link, array("/about", "/contact", "/convene", "/implement", "/map", "/open-data-roundtables" ))) {
		echo "in array";
		$app->redirect($actual_link.".html");
	}
    $app->redirect('/404.html');
});
// ************
//-----------------------------------------------------
// display placeholder landing page
$app->get('/info', function () use ($app) {
    $paramValue = $app->request->get('param');
    
    $content['title'] = "ODE Survery Studies";
    $content['intro'] = <<<HTML
		<p>Home ODE Survey Studies</p>
HTML;
	// return $app->response->setBody($response);
	// Render content with simple bespoke templates
	$app->view()->setData(array('content' => $content));
	$app->render('survey/tp_start.php');
});
// ************
$app->get('/admin/login/', function () use ($app) {
	
    $content['title'] = "Open Data Impact Map Admin";
    $content['intro'] = <<<HTML
		<p>Open Data Impact Map Admin</p>
HTML;
	// return $app->response->setBody($response);
	// Render content with simple bespoke templates
	$app->view()->setData(array('content' => $content));
	$app->render('admin/tp_login.php');
    
});
// ************
$app->post('/admin/login/', function () use ($app) {
	echo "route to login";
	return true;
    
});
// ************
$app->get('/admin/protected/', function () use ($app) {
	//echo "protected";
	// Requires login to access
	$app->render('admin/tp_admin_home.php');
	// if ( !isset($_SESSION['username']) ) {
	// 	// echo "<br> no username";
	// 	$app->redirect("/survey/admin/login/");
	// }
    $paramValue = $app->request->get('param');
    
    $content['title'] = "ODE Survery Studies";
    $content['intro'] = <<<HTML
		<p>Home ODE Survey Studies</p>
HTML;
	// return $app->response->setBody($response);
	// Render content with simple bespoke templates
	$app->view()->setData(array('content' => $content));
	//$app->render('admin/tp_admin_home.php');
});
// ************
$app->get('/admin/', function () use ($app) {
	// Requires login to access
	if ( !isset($_SESSION['username']) ) {
		// echo "<br> no username";
		$app->redirect("/survey/admin/login/");
	}
	echo "<br><br>This is a protected route/path/page";
	return true;
});
// ************
$app->get('/admin/logout/', function () use ($app) {
	session_unset();
	session_destroy();
	$app->redirect("/survey/admin/login/");
});
// ************
$app->get('/index.html', function () use ($app) {
	// Route /survey/index.html to /start/
	//its calling start function twice. One from index.html and then from survey.
  $app->redirect("/survey/start/");
});
// ************
$app->get('/', function () use ($app) {
	
	$actual_link = "$_SERVER[REQUEST_URI]";
	
	// Let's make sure we remove a trailing "/" on any not found paths
        $actual_link = rtrim($actual_link, '/');
	// Any change to below array must also be made to identical array in route "/" around line 91
	if (in_array($actual_link, array("/map", "/regions", "/sectors", "/usecases", "/contact" ))) {
		echo "in array";
		$app->redirect($actual_link.".html");
	}
    $app->redirect("index.html");
});
// ************
$app->get('', function () use ($app) {
// echo "route ''";exit;
    $app->redirect("index.html");
});
// ************
$app->get('/admin/delete/test/confirmed', function () use ($app) {
	
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	echo "THIS DELETES DATA";
	$parse_params = array(
		'className' => 'org_profile',
		'object' => array(),
		'query' => array(
        	'org_profile_status' => 'test'
    	)
    );
	$request = $parse->delete($parse_params);
    $response = json_decode($request, true);
    print_r($response);
    exit;
});
// ************
$app->get('/oops/', function () use ($app) {
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Oops";
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	
	$app->view()->setData(array('content' => $content ));
	$app->render('survey/tp_oops.php');
});
// ************
// ************
$app->get('/start/internal/add/', function () use ($app) {
	
	// Requires login to access
	// if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	// $parse = new parseRestClient(array(
	// 	'appid' => PARSE_APPLICATION_ID,
	// 	'restkey' => PARSE_API_KEY
	// ));
	
	// $survey_object = array("survey_name" => "opendata", "action" => "start", "notes" => "");
	// # store new information as new record 
 //    $parse_params = array(
	// 	'className' => 'survey',
	// 	'object' => $survey_object
 //    );
	
	// // Create Parse object and save
 //    try {
 //    	$request = $parse->create($parse_params);
 //    	$response = json_decode($request, true);
 //    } catch (Exception $e) {
 //    	 echo 'Caught exception: ',  $e->getMessage(), "\n";
 //    	 $app->redirect("/survey/oops/");
 //    }
	$survey_name = "opendata";
	$notes = "";
    
	$id_query = "SELECT max(profile_id) as max FROM org_profiles";
   	
	try {
        $conn = connect_db();
        $stmt = $conn->query($id_query);
        $row = $stmt->fetchObject();        
    } 
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }     

   	$next_id = isset($row->max) ? intval($row->max) + 1 : null;

    if(isset($next_id)) {    	
    	// Success    	
    	$new_id = $next_id;

    	// Check the next ID if it is already taken.
    	while (1) {
	    	$check_query="SELECT profile_id FROM org_surveys WHERE profile_id=:next_id";
	    	try {
		    	$stmt = $conn->prepare($check_query);
		    	$stmt->bindParam("next_id", $new_id);
		    	$stmt->execute();
		    	$row = $stmt->fetchObject(); 	    	
		    } catch(PDOException $e) {
		        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		    }

		    if (isset($row->profile_id)){
		    	$new_id =  intval($row->profile_id) + 1;
		    } else {
		    	break;
		    }
	    } 

    	$survey_query="INSERT INTO org_surveys (profile_id, survey_name) 
			  VALUES (:new_id, :survey_name)";

		try {	        
	        $stmt = $conn->prepare($survey_query);
	        $stmt->bindParam("new_id", $new_id);
	        $stmt->bindParam("survey_name", $survey_name);
	        $stmt->execute();
	    } 
	    catch(PDOException $e) {
	        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	    }  
	    
    	$app->redirect("/survey/".$new_id."/form/internal/add/");
    	
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    //	exit;
    //	$app->redirect("/error".$org_surveys['object_id']);
    }
});
$app->get('/start/', function () use ($app) { 
	
	$survey_name = "opendata";
	$notes = "";
    
	$id_query = "SELECT max(profile_id) as max FROM org_profiles";
   	
	try {
        $conn = connect_db();
        $stmt = $conn->query($id_query);
        $row = $stmt->fetchObject();        
    } 
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }     

   	$next_id = isset($row->max) ? intval($row->max) + 1 : null;

    if(isset($next_id)) {    	
    	// Success    	
    	$new_id = $next_id;

    	// Check the next ID if it is already taken.
    	while (1) {
	    	$check_query="SELECT profile_id FROM org_surveys WHERE profile_id=:next_id";
	    	try {
		    	$stmt = $conn->prepare($check_query);
		    	$stmt->bindParam("next_id", $new_id);
		    	$stmt->execute();
		    	$row = $stmt->fetchObject(); 	    	
		    } catch(PDOException $e) {
		        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		    }

		    if (isset($row->profile_id)){
		    	$new_id =  intval($row->profile_id) + 1;
		    } else {
		    	break;
		    }
	    } 

    	$survey_query="INSERT INTO org_surveys (profile_id, survey_name) 
			  VALUES (:new_id, :survey_name)";

		try {	        
	        $stmt = $conn->prepare($survey_query);
	        $stmt->bindParam("new_id", $new_id);
	        $stmt->bindParam("survey_name", $survey_name);
	        $stmt->execute();
	    } 
	    catch(PDOException $e) {
	        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	    }  
	    
    	$app->redirect("/survey/". $new_id ."/form");
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    	exit;
    	$app->redirect("/error" . $new_id);
    }
});
// ************
$app->get('/start/:lang/', function ($lang) use ($app) {
	
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	
	$survey_object = array("survey_name" => "opendata", "action" => "start", "notes" => "");
	# store new information as new record 
    $parse_params = array(
		'className' => 'survey',
		'object' => $survey_object
    );
	
	// Create Parse object and save
    try {
    	$request = $parse->create($parse_params);
    	$response = json_decode($request, true);
    } catch (Exception $e) {
    	 echo 'Caught exception: ',  $e->getMessage(), "\n";
    	 $app->redirect("/survey/oops/");
    }
    if(isset($response['objectId'])) {
    	// Success
		$app->redirect("/survey/".$response['objectId']."/form/$lang/");
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    	exit;
    	$app->redirect("/error".$response['objectId']);
    }
});
// ************
$app->get('/:surveyId/form', function ($lastsurvey_id) use ($app) {
	$app->log->debug(date_format(date_create(), 'Y-m-d H:i:s')."; DEBUG; "."new survey created, ...");
	
	// bring up new blank survey
	$content['surveyId'] = $lastsurvey_id;
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey";
	$content['language'] = "en_US";
	$app->view()->setData(array('content' => $content ));
	$app->render('survey/tp_survey.php');
});
// ************
$app->get('/:surveyId/form/:lang/', function ($lastsurvey_id, $lang) use ($app) {
	// $app->log->debug(date_format(date_create(), 'Y-m-d H:i:s')."; DEBUG; "."new survey created, ...");
	
	// bring up new blank survey
	$content['surveyId'] = $lastsurvey_id;
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey";
	$content['language'] = $lang;

	$app->view()->setData(array('content' => $content ));
	// $app->render('survey/tp_survey_es.php');
	$app->render('survey/tp_survey_gettext.php');
});
// ************

$app->get('/:surveyId/form/internal/add/', function ($lastsurvey_id) use ($app) {
	// Requires login to access
	//if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	$app->log->debug(date_format(date_create(), 'Y-m-d H:i:s')."; DEBUG; "."new internal survey created, ...");
	
	// bring up new blank survey
	$content['surveyId'] = $lastsurvey_id;
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey (Internal)";
	$content['language'] = "en_US";
	
	//echo json_encode($users);
	$app->view()->setData(array('content' => $content ));
	$app->render('survey/tp_survey_less_req.php');
});


// ********* Data Insertion **********
$app->post('/2du/:surveyId/', function ($lastsurvey_id) use ($app) {
    
	// Access post variables from submitted survey form
	$allPostVars = $app->request->post(); 	
	$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; INFO; ". str_replace("\n", "||", print_r("Survey " . strval($lastsurvey_id) . " created.", true)) );

	// echo "<pre>";
	// print_r( $allPostVars);
	// echo "</pre>";
	// exit;

    // Set string values to numeric values
    $allPostVars["org_profile_year"] = intval($allPostVars["org_profile_year"]);
    $allPostVars["org_year_founded"] = intval($allPostVars["org_year_founded"]);
    $allPostVars["latitude"] = floatval($allPostVars["latitude"]);
    $allPostVars["longitude"] = floatval($allPostVars["longitude"]);

    // DB Connection 
    try{
    	$conn = connect_db();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
	// $wb_region = addWbRegions($org_country_info['org_hq_country_locode']);

	// Country Info
    $country_code = isset($allPostVars['org_hq_country_locode']) ? $allPostVars['org_hq_country_locode'] : null;
    $check_country_query = "SELECT * FROM org_country_info where ISO2=:country_code";
    try {
    	$stmt = $conn->prepare($check_country_query);
    	$stmt->bindParam("country_code", $country_code);
    	$stmt->execute();
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);
    	if(isset($row['country_id'])) {
    		$country_id = $row['country_id'];
	    } 
    }catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }    
     
    /* Location Info */
    $city = isset($allPostVars['org_hq_city']) ? $allPostVars['org_hq_city'] : null;
    $province = isset($allPostVars['org_hq_st_prov']) ? $allPostVars['org_hq_st_prov'] : null;
    $latitude = isset($allPostVars['latitude']) ? $allPostVars['latitude'] : null;
    $longitude = isset($allPostVars['longitude']) ? $allPostVars['longitude'] : null;

    if (isset($city) || isset($province)) {
	    try {
	    	$check_city_query = "SELECT * FROM org_locations where org_hq_city=:city and org_hq_st_prov=:province";

	    	$stmt = $conn->prepare($check_city_query);
	    	$stmt->bindParam("city", $city);
	    	$stmt->bindParam("province", $province);
	    	$stmt->execute();
	    	$row = $stmt->fetch(PDO::FETCH_ASSOC);	    	
	    }catch(PDOException $e) {
	        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	    } 

	    // if the city and province is already registered in the database...
	    if(isset($row['location_id'])) {
	    	$location_id = $row['location_id'];
		}
		// if the city is new to the database... 
		else {
		  	$locationInfoQuery = "INSERT INTO org_locations 
		  						(org_hq_city, org_hq_st_prov, country_id, latitude, longitude) 
		  						VALUES 
							 	(:org_hq_city, :org_hq_st_prov, :country_id, :latitude, :longitude)";

		 	try {
			 	$stmt1 = $conn->prepare($locationInfoQuery);				 	
			 	$stmt1->bindParam("org_hq_city", $city);				 	
			 	$stmt1->bindParam("org_hq_st_prov", $province);
			 	$stmt1->bindParam("country_id",$country_id);
			 	$stmt1->bindParam("latitude", $latitude);
			 	$stmt1->bindParam("longitude", $longitude);
			 	$stmt1->execute();
				$location_id = $conn->lastInsertId();
				
		    }catch(PDOException $e) {
		    	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		    }
		}
    }

    // Created at
	date_default_timezone_set('America/New_York');
	$createdAt = date('Y-m-d H:i:s', time());

	$check_profile_query = "SELECT * FROM org_profiles where profile_id=:profile_id";
    try {
    	$stmt = $conn->prepare($check_profile_query);
    	$stmt->bindParam("profile_id", $lastsurvey_id);
    	$stmt->execute();
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    	if(isset($row['profile_id'])) {
    		$org_profile_query = "UPDATE org_profiles SET
			    	country_id = :country_id,
				    industry_id = :industry_id,
				    industry_other =:industry_other,
				    location_id = :location_id,
				    no_org_url =:no_org_url,
				    org_additional =:org_additional,
				    org_description =:org_description,
				    org_greatest_impact =:org_greatest_impact,
				    org_greatest_impact_detail =:org_greatest_impact_detail,
				    org_name =:org_name,
				    org_size =:org_size,
				    org_profile_category =:org_profile_category,
				    org_profile_src =:org_profile_src,
				    org_profile_status =:org_profile_status,
				    org_profile_year=:org_profile_year,
				    org_type=:org_type,
				    org_type_other=:org_type_other,
				    org_url=:org_url,
				    org_year_founded = :org_year_founded,
				    createdAt = :createdAt,
				    machine_read = :machine_read,
				    data_country_count = :data_country_count 
				    WHERE profile_id = :profile_id";
	    } else {
	    	/* Inserting into org_profile table */
		    $org_profile_query = "INSERT INTO org_profiles(
		    		profile_id,
			    	country_id,
				    industry_id,
				    industry_other,
				    location_id,
				    no_org_url,
				    org_additional,
				    org_description,
				    org_greatest_impact,
				    org_greatest_impact_detail,
				    org_name,
				    org_size,
				    org_profile_category,
				    org_profile_src,
				    org_profile_status,
				    org_profile_year,
				    org_type,
				    org_type_other,
				    org_url,
				    org_year_founded,
				    createdAt,
				    machine_read,
				    data_country_count
				) VALUES (
					:profile_id,
					:country_id,
					:industry_id,
					:industry_other,
					:location_id,
					:no_org_url,
					:org_additional,
					:org_description,
					:org_greatest_impact,
					:org_greatest_impact_detail,
					:org_name,
					:org_size,
				    :org_profile_category,
				    :org_profile_src,
				    :org_profile_status,
				    :org_profile_year,
				    :org_type,
				    :org_type_other,
				    :org_url,
				    :org_year_founded,
				    :createdAt,
				    :machine_read,
				    :data_country_count
				)";
	    }
    }catch(PDOException $e) {
    	echo '<br>' . $org_profile_query;
    	echo '<br>';
    	print_r($row);
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }    
	     
    $industry_id = isset($allPostVars['industry_id']) ? $allPostVars['industry_id'] : null;
    $industry_other = isset($allPostVars['industry_other']) ? htmlspecialchars($allPostVars['industry_other']) : null;
    $no_org_url = isset($allPostVars['no_org_url']) ? $allPostVars['no_org_url'] : null;
    $org_additional = isset($allPostVars['org_additional']) ? $allPostVars['org_additional']: null;
    $org_description = isset($allPostVars['org_description']) ? htmlspecialchars($allPostVars['org_description']) : null;
    $org_greatest_impact = isset($allPostVars['org_greatest_impact']) ? htmlspecialchars($allPostVars['org_greatest_impact']) : null;
    $org_greatest_impact_detail = isset($allPostVars['org_greatest_impact_detail']) ? htmlspecialchars($allPostVars['org_greatest_impact_detail']) : null;
    $org_name = isset($allPostVars['org_name']) ? htmlspecialchars($allPostVars['org_name']) : null;
    $org_profile_category = isset($allPostVars['org_profile_category']) ? htmlspecialchars($allPostVars['org_profile_category']) : null;
    $org_profile_src = isset($allPostVars['org_profile_src']) ? htmlspecialchars($allPostVars['org_profile_src']) : null;
    $org_profile_status = isset($allPostVars['org_profile_status']) ? strval($allPostVars['org_profile_status']): null;
    $org_profile_year = isset($allPostVars['org_profile_year']) ? intval($allPostVars['org_profile_year']): null;
    $org_size = isset($allPostVars['org_size_id']) ? strval($allPostVars['org_size_id']) : null;
    $org_type = isset($allPostVars['org_type']) ? strval($allPostVars['org_type']) : null;
    $org_type_other = isset($allPostVars['org_type_other']) ? htmlspecialchars($allPostVars['org_type_other']) : null;
    $org_url = isset($allPostVars['org_url']) ? strval($allPostVars['org_url']) : null;
    $org_year_founded = isset($allPostVars['org_year_founded']) ? intval($allPostVars['org_year_founded']): null;
    $machine_read = isset($allPostVars["m_read"]) ? $allPostVars["m_read"] : null;
    $data_country_count = isset($allPostVars["data_country_count"]) ? strval($allPostVars["data_country_count"]) : null;

 	try {
        $stmt2 = $conn->prepare($org_profile_query);
        $stmt2->bindParam("industry_id", $industry_id);
		$stmt2->bindParam("industry_other", $industry_other);
		$stmt2->bindParam("no_org_url", $no_org_url);
		$stmt2->bindParam("org_additional", $org_additional);
		$stmt2->bindParam("org_description", $org_description);
		$stmt2->bindParam("org_greatest_impact", $org_greatest_impact);
		$stmt2->bindParam("org_greatest_impact_detail", $org_greatest_impact_detail);
		$stmt2->bindParam("org_name", $org_name);
		$stmt2->bindParam("org_profile_category", $org_profile_category);
		$stmt2->bindParam("org_profile_src", $org_profile_src);
		$stmt2->bindParam("org_profile_status", $org_profile_status);
		$stmt2->bindParam("org_profile_year", $org_profile_year);
		$stmt2->bindParam("org_size", $org_size);
		$stmt2->bindParam("org_type", $org_type);
		$stmt2->bindParam("org_type_other", $org_type_other);
		$stmt2->bindParam("org_url", $org_url);
		$stmt2->bindParam("org_year_founded", $org_year_founded);
		$stmt2->bindParam("profile_id", $lastsurvey_id);
		$stmt2->bindParam("location_id",$location_id);
		$stmt2->bindParam("country_id",$country_id);
		$stmt2->bindParam("createdAt",$createdAt);
		$stmt2->bindParam("machine_read",$machine_read);
		$stmt2->bindParam("data_country_count",$data_country_count);
        $stmt2->execute();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        print_r($org_profile_query);
    }        


    /* org_contacts */
    $survey_contact_first = isset($allPostVars["survey_contact_first"]) ? htmlspecialchars($allPostVars["survey_contact_first"]) : null;
    $survey_contact_last =  isset($allPostVars["survey_contact_last"]) ? htmlspecialchars($allPostVars["survey_contact_last"]) : null;
    $survey_contact_title = isset($allPostVars["survey_contact_title"]) ? htmlspecialchars($allPostVars["survey_contact_title"]) : null;
    $survey_contact_email = isset($allPostVars["survey_contact_email"]) ? htmlspecialchars($allPostVars["survey_contact_email"]) : null;
    $survey_contact_phone = isset($allPostVars["survey_contact_phone"]) ? htmlspecialchars($allPostVars["survey_contact_phone"]) : null;

  	// Checking existing data
    $check_contact_query = "SELECT * FROM org_contacts where profile_id=:profile_id";
    try {
    	$stmt = $conn->prepare($check_contact_query);
    	$stmt->bindParam("profile_id", $lastsurvey_id);
    	$stmt->execute();
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    	if(isset($row['profile_id'])) {
    		$contact_info_query = "UPDATE org_contacts SET 
				survey_contact_first = :survey_contact_first,
				 survey_contact_last = :survey_contact_last,
				 survey_contact_title = :survey_contact_title,
				 survey_contact_email = :survey_contact_email,
				 survey_contact_phone = :survey_contact_phone
				 WHERE profile_id = :profile_id";
	    } else {
	    	$contact_info_query = "INSERT INTO org_contacts
				(survey_contact_first,
				 survey_contact_last,
				 survey_contact_title,
				 survey_contact_email,
				 survey_contact_phone,
				 profile_id
				) VALUES 
				(:survey_contact_first,
				:survey_contact_last,
				:survey_contact_title,
				:survey_contact_email,
				:survey_contact_phone,
				:profile_id
				)";
	    }
    }catch(PDOException $e) {
    	echo '<br>' . $check_contact_query;
    	echo '<br>';    	
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }    
    
    try {
        $stmt = $conn->prepare($contact_info_query);
        $stmt->bindParam("survey_contact_first",$survey_contact_first);
		$stmt->bindParam("survey_contact_last",$survey_contact_last); 
		$stmt->bindParam("survey_contact_title",$survey_contact_title);
		$stmt->bindParam("survey_contact_email",$survey_contact_email);
		$stmt->bindParam("survey_contact_phone",$survey_contact_phone);
		$stmt->bindParam("profile_id",$lastsurvey_id);
        $stmt->execute();
    } catch(PDOException $e) {
    	echo '<br>' . $contact_info_query;
    	echo '<br>';
        echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
    }   


    /* Data Applications */
    $use_advocacy = (!isset($allPostVars["use_advocacy"]) || empty($allPostVars["use_advocacy"])) ? FALSE : TRUE;
    $use_prod_srvc = (!isset($allPostVars["use_prod_srvc"]) || empty($allPostVars["use_prod_srvc"])) ? FALSE : TRUE;
    $use_research = (!isset($allPostVars["use_research"]) || empty($allPostVars["use_research"])) ? FALSE : TRUE;
    $use_org_opt = (!isset($allPostVars["use_org_opt"]) || empty($allPostVars["use_org_opt"])) ? FALSE : TRUE;
    $use_other = (!isset($allPostVars["use_other"]) || empty($allPostVars["use_other"])) ? FALSE : TRUE;

    $use_advocacy_desc = isset($allPostVars["use_advocacy_desc"]) ? htmlspecialchars($allPostVars["use_advocacy_desc"]) : null;
    $use_org_opt_desc = isset($allPostVars["use_org_opt_desc"]) ? htmlspecialchars($allPostVars["use_org_opt_desc"]) : null;
    $use_other_desc = isset($allPostVars["use_other_desc"]) ? htmlspecialchars($allPostVars["use_other_desc"]) : null;
    $use_prod_srvc_desc = isset($allPostVars["use_prod_srvc_desc"]) ? htmlspecialchars($allPostVars["use_prod_srvc_desc"]) : null;
    $use_research_desc = isset($allPostVars["use_research_desc"]) ? htmlspecialchars($allPostVars["use_research_desc"]) : null;
   	

	// Checking existing data
    $check_app_query = "SELECT * FROM data_applications where profile_id=:profile_id";
    try {
    	$stmt = $conn->prepare($check_app_query);
    	$stmt->bindParam("profile_id", $lastsurvey_id);
    	$stmt->execute();
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);

    	if(isset($row['profile_id'])) {
    		$data_info_query ="UPDATE data_applications SET
		    	advocacy =:use_advocacy,  
		    	advocacy_desc=:use_advocacy_desc, 
		    	org_opt=:use_org_opt, 
		    	org_opt_desc=:use_org_opt_desc, 
		    	use_other=:use_other,  
		    	use_other_desc=:use_other_desc, 
		    	prod_srvc=:use_prod_srvc,    
		    	prod_srvc_desc=:use_prod_srvc_desc,
		    	research=:use_research,
		    	research_desc=:use_research_desc
		    	WHERE profile_id = :profile_id";
	    } else {
	    	$data_info_query ="INSERT INTO data_applications
		    	(advocacy, 
		    	advocacy_desc, 
		    	org_opt, 
		    	org_opt_desc, 
		    	use_other, 
		    	use_other_desc, 
		    	prod_srvc,    
		    	prod_srvc_desc,
		    	research,
		    	research_desc,
		    	profile_id)
		    VALUES (
		    	:use_advocacy, 
		    	:use_advocacy_desc, 
		    	:use_org_opt, 
		    	:use_org_opt_desc, 
		    	:use_other, 
		    	:use_other_desc, 
		    	:use_prod_srvc, 
		    	:use_prod_srvc_desc,
		    	:use_research,
		    	:use_research_desc,
		    	:profile_id)";
	    }
    }catch(PDOException $e) {
    	echo '<br>' . $check_app_query . '<br>';    	
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }    

	try {
        $stmt = $conn->prepare($data_info_query);
        $stmt->bindParam("use_advocacy",$use_advocacy);
		$stmt->bindParam("use_advocacy_desc",$use_advocacy_desc);
		$stmt->bindParam("use_org_opt",$use_org_opt);
		$stmt->bindParam("use_org_opt_desc",$use_org_opt_desc);
		$stmt->bindParam("use_other",$use_other);
		$stmt->bindParam("use_other_desc",$use_other_desc);
		$stmt->bindParam("use_prod_srvc",$use_prod_srvc);
		$stmt->bindParam("use_prod_srvc_desc",$use_prod_srvc_desc);
		$stmt->bindParam("use_research",$use_research);
		$stmt->bindParam("use_research_desc",$use_research_desc);
		$stmt->bindParam("profile_id",$lastsurvey_id);
        $stmt->execute();
    } catch(PDOException $e) {
    	echo '<br>' . $data_info_query . '<br>';
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }   

    /* Data USE */
    $idSuffixNum = 1;

    $type_to_input = array();

    while (array_key_exists('dataUseData-'.$idSuffixNum, $allPostVars)) {
		
		$data_use_type = isset($allPostVars['data_use_type']) ? $allPostVars['data_use_type'] : null;
		
		if(isset($allPostVars['dataUseData-'.$idSuffixNum])) {

			foreach ($allPostVars['dataUseData-'.$idSuffixNum] as $row){

				// Country Search
				$src_country_locode = strval($row['src_country_locode']);
				$src_country_name = addWbRegions($src_country_locode);
				
				$check_country_query = "SELECT * FROM org_country_info WHERE org_hq_country=:src_country_name";
				
			    try {
			    	$stmt = $conn->prepare($check_country_query);
			    	$stmt->bindParam("src_country_name", $src_country_name['org_hq_country_name']);
			    	$stmt->execute();
			    	$rows = $stmt->fetch(PDO::FETCH_ASSOC);

			    	if(isset($rows['country_id'])) {
			    		$src_country_id = $rows['country_id'];
				    } else {
				    	$src_country_id = 0;
				    }
			    } catch(PDOException $e) {
			        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
			    }

			    $temp[$src_country_id] = array();
			    
		    	foreach ($data_use_type as $type) {
		    		if (isset($row['type'][$type])){
		    			
		    			foreach ($row['type'][$type]['src_gov_level'] as $k=>$v){
		    				$temp[$src_country_id][$type][$k] = $v;
		    			}
		    		} else {
		    			$temp[$src_country_id][$type] = null;
		    		}

		    	}
		    	array_push($type_to_input, $temp);


			}
		}
	
				
		$idSuffixNum++;
	}

	/* Inserting into the Data Use Table */
	$delete_query = "DELETE FROM org_data_use WHERE profile_id=:profile_id";
				
    try {
    	$stmt = $conn->prepare($delete_query);
    	$stmt->bindParam("profile_id", $lastsurvey_id);
    	$stmt->execute();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }

    $other = isset($allPostVars['data_use_type_other']) ? htmlspecialchars($allPostVars['data_use_type_other']) : null;

    if (isset($type_to_input[0])) {
		foreach ($type_to_input[0] as $cid => $ty){
			foreach ($ty as $t => $l){
				
		    	$data_use_query ="INSERT INTO org_data_use
				    (
				    	data_type, 
				    	data_use_type_other, 
				    	data_src_gov_level, 
				    	profile_id, 
				    	src_country_id, 
				    	machine_read
			    	)
			    	VALUES (
				    	:data_type, 
				    	:data_use_type_other, 
				    	:data_src_gov_level, 
				    	:profile_id, 
				    	:src_country_id, 
				    	:machine_read
			    	)";

		    	try {
			    	$stmt = $conn->prepare($data_use_query);
			    	$stmt->bindParam("data_type", $t);

			    	if ($t == "Other"){	
			    		$stmt->bindParam("data_use_type_other", $other);
			    	} else {
			    		$null = null;
			    		$stmt->bindParam("data_use_type_other", $null);
			    	}
			    	
			    	if (isset($l[0])){
			    		$stmt->bindParam("data_src_gov_level", $l[0]);
			    	} else{
			    		$null = null;
			    		$stmt->bindParam("data_src_gov_level", $null);
			    	}
			    	
			    	$stmt->bindParam("profile_id", $lastsurvey_id);
			    	$stmt->bindParam("src_country_id", $cid);
			    	$stmt->bindParam("machine_read", $machine_read);
			    	$stmt->execute();
			    	
			    } catch(PDOException $e) {
			        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
			    }

			    if (isset($l[1])) {
			    	$null = null;

					try {
				    	$stmt = $conn->prepare($data_use_query);
				    	$stmt->bindParam("data_type", $t);

				    	if ($t == "Other"){	
				    		$stmt->bindParam("data_use_type_other", $other);
				    	} else {
				    		$stmt->bindParam("data_use_type_other", $null);
				    	}
				    	
				    	$stmt->bindParam("data_src_gov_level", $l[1]);
				      	$stmt->bindParam("profile_id", $lastsurvey_id);
				    	$stmt->bindParam("src_country_id", $cid);
				    	$stmt->bindParam("machine_read", $machine_read);
				    	$stmt->execute();
				    	
				    } catch(PDOException $e) {
				        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
				    }
			    }

				
			}
		}
	}

	// If we made it here, everything saved.
	// ==========================================
	// All data saved, send a confirmation email
	// ==========================================
	/* Send one per survey submission */
	// Instantiate the client.
	if ($allPostVars['org_profile_status'] == "edit"){
			// Instantiate the client.
		$mgClient = new Mailgun(MAILGUN_APIKEY);
		$domain = MAILGUN_SERVER;
		$org_name = $allPostVars['org_name'];
		$old_id = $allPostVars['old_profile_id'];
		$new_id = $allPostVars['new_profile_id'];
		$emailtext = <<<EOL
An EDIT was filled out for Org Profile.
The organization name in the new survey: ${org_name}
The old profile ID is: ${old_id} 
The new profile ID is: ${new_id}
View the new profile here: http://${_SERVER['HTTP_HOST']}/survey/edit/${new_id}
EOL;
		// Send email with mailgun
		$result = $mgClient->sendMessage($domain, array(
			'from'    => 'Center for Open Data Enterprise <mailgun@test.opendataimpactmap.org>',
			'to'      => '<'.'myeong@odenterprise.org'.'>',
			'subject' => "Open Data Impact Map: EDIT FOR PROFILE ${new_id}",
			'text'    => $emailtext
		));
		$app->redirect("/survey/submitted/".$new_id);
	} else {
		$mgClient = new Mailgun(MAILGUN_APIKEY);
		$domain = MAILGUN_SERVER;
		$emailtext = <<<EOL
Thank you for participating in the Open Data Impact Map. Your contribution helps make the Map a truly global view of open data’s impact. You can view your submission here: http://${_SERVER['HTTP_HOST']}/survey/${lastsurvey_id}
Please help us spread the word by sharing the survey http://www.opendataenterprise.org/survey
If you know of any other organizations using open data, are interested in becoming a regional supporter, or have any questions, please email us at map@odenterprise.org.
Many thanks, 
The Center for Open Data Enterprise
EOL;
	    if ( strlen($allPostVars['survey_contact_email']) > 0 && SEND_MAIL) {
			// Send email with mailgun
			$result = $mgClient->sendMessage($domain, array(
				'from'    => 'Center for Open Data Enterprise <mailgun@sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org>',
				'to'      => '<'.$allPostVars['survey_contact_email'].'>',
				'subject' => "Open Data Impact Map: SUBMISSION RECEIVED",
				'text'    => $emailtext
			));
			// echo "<pre>";print_r($result); echo "</pre>";exit;
	    }
	    $app->redirect("/survey/submitted/".$lastsurvey_id);
	}
});
// end du new post here
// ************
$app->get('/submitted/:surveyId/', function ($lastsurvey_id) use ($app) {
	
	$content['surveyId'] = $lastsurvey_id;
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Thank You";
	$content['language'] = "en_US";
	$app->view()->setData(array('content' => $content));
	$app->render('survey/tp_thankyou.php');
});
// ************
$app->get('/:surveyId/submitted/', function ($lastsurvey_id) use ($app) {
		$db = connect_db();
		$org_profile_query="select * from org_profiles where object_id=?";
		$stmt = $db->prepare($org_profile_query); 
		$stmt->bindParam(1, $lastsurvey_id);
		$stmt->execute();
		$query_results = $stmt->fetchAll();
		$request_decoded = json_decode($query_results, true);
	    $org_profile = $request_decoded['results'][0];
		$db = connect_db();
		$org_data_use_query="select * from org_data_sources where object_id=?";
		$stmt = $db->prepare($org_data_use_query); 
		$stmt->bindParam(1, $lastsurvey_id);
		$stmt->execute();
		$query_results_data = $stmt->fetchAll();
		$request_decoded = json_decode($query_results_data, true);
	    $org_data_use = $request_decoded['results'][0];
		$content['surveyId'] = $lastsurvey_id;
		$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
		$content['surveyName'] = "opendata";
		$content['title'] = "Open Data Enterprise Survey - Submitted";
		$content['language'] = "en_US";
	
	$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile, 'org_data_use' => $org_data_use ));
	$app->render('survey/tp_submitted.php');
});
// ************
$app->get('/company/:profile_id/edit', function ($profile_id) use ($app) {
	$app->redirect("/survey/edit/".$profile_id);
});
// ************
$app->get('/:profile_id/edit', function ($profile_id) use ($app) {
	$app->redirect("/survey/edit/".$profile_id);
});
// ************
$app->get('/edit/:profile_id', function ($profile_id) use ($app) {
	$db = connect_db();
	$org_profile_query="select org_name from org_profiles where profile_id=:pid";
	$stmt = $db->prepare($org_profile_query); 
	$stmt->bindParam("pid", $profile_id);
	$stmt->execute();

	$org_profile = $stmt->fetchAll();
	if (count($org_profile) > 0) {
		$org_name = $org_profile[0]['org_name'];
	} else {
		$app->redirect("/org/".$profile_id."/notfound/");
	}
	
	$content['surveyId'] = $profile_id;
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Edit Message";
	$content['language'] = "en_US";
	
	$app->view()->setData(array('content' => $content, 'org_name' => $org_name ));
	$app->render('survey/tp_profile_edit_msg.php');
});

/*
* Editing an existing survey
*/
$app->get('/edit/:profile_id/form', function ($profile_id) use ($app) {
	// loading a profile 
	$db = connect_db(); 
	$org_profile_query="SELECT * FROM org_profiles as p LEFT JOIN org_locations as l ON p.location_id = l.location_id
														LEFT JOIN org_country_info as c ON p.country_id = c.country_id
														LEFT JOIN data_applications as a ON p.profile_id = a.profile_id
														WHERE p.profile_id=:pid";
	$stmt = $db->prepare($org_profile_query); 
	$stmt->bindParam("pid", $profile_id);
	$stmt->execute();
	$org_profile = $stmt->fetchAll();

		
	if (!isset($org_profile[0]['profile_id'])) {
		$app->redirect("/survey/".$profile_id."/notfound/");
	}

	// loading a data_use
	$org_data_use_query="SELECT * from org_data_use where profile_id=:pid"; 
	$stmt = $db->prepare($org_data_use_query); 
	$stmt->bindParam("pid", $profile_id);
	$stmt->execute();
	$org_data_use = $stmt->fetchAll();
	$org_data_use1 = array();

	foreach ($org_data_use as $use){
		array_push($org_data_use1, $use['data_type']);
	}
	$org_data_use1 = array_unique($org_data_use1);

	// echo "<pre>";
	// print_r($org_data_use1);
	// echo "</pre>";
	// exit;

    // creating a new Profile ID 
	$survey_name = "opendata";
	$notes = "";
    
	$id_query = "SELECT max(profile_id) as max FROM org_profiles";
   	
	try {
        $conn = connect_db();
        $stmt = $conn->query($id_query);
        $row = $stmt->fetchObject();        
    } 
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }     

   	$next_id = isset($row->max) ? intval($row->max) + 1 : null;

    if(isset($next_id)) {    	
    	// Success    	
    	$new_id = $next_id;

    	// Check the next ID if it is already taken.
    	while (1) {
	    	$check_query="SELECT profile_id FROM org_surveys WHERE profile_id=:next_id";
	    	try {
		    	$stmt = $conn->prepare($check_query);
		    	$stmt->bindParam("next_id", $new_id);
		    	$stmt->execute();
		    	$row = $stmt->fetchObject(); 	    	
		    } catch(PDOException $e) {
		        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		    }

		    if (isset($row->profile_id)){
		    	$new_id =  intval($row->profile_id) + 1;
		    } else {
		    	break;
		    }
	    } 

    	$survey_query="INSERT INTO org_surveys (profile_id, survey_name) 
			  VALUES (:new_id, :survey_name)";

		try {	        
	        $stmt = $conn->prepare($survey_query);
	        $stmt->bindParam("new_id", $new_id);
	        $stmt->bindParam("survey_name", $survey_name);
	        $stmt->execute();
	    } 
	    catch(PDOException $e) {
	        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	    }  
	    
    } else {
    	// Failure
    	echo "Problem. Promlem with record creation not yet handled.";
    	exit;
    	$app->redirect("/error" . $new_id);
    }

    // store new information as new record 	
	$content['surveyId'] = $new_id;
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Edit";
	$content['language'] = "en_US";
	
	$app->view()->setData(array('content' => $content, 'org_profile' => $org_profile, 'org_data_use' => $org_data_use, 'org_data_use1' => $org_data_use1));
	$app->render('survey/tp_profile_edit.php');  
});
// ************
$app->post('/:surveyId/editform', function ($lastsurvey_id) use ($app) {
	$db = connect_db();
     // Access post variables from submitted survey form
	$allPostVars = $app->request->post();
	$edits = print_r($allPostVars, true);
	// Instantiate the client.
	$mgClient = new Mailgun(MAILGUN_APIKEY);
	$domain = MAILGUN_SERVER;
	$emailtext = <<<EOL
An EDIT was filled out for Org Profile: ${lastsurvey_id}} 
View the current profile here: http://${_SERVER['HTTP_HOST']}/survey/${lastsurvey_id}
The submitted changes are below:
$edits
EOL;
	// Send email with mailgun
	$result = $mgClient->sendMessage($domain, array(
		'from'    => 'Center for Open Data Enterprise <mailgun@sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org>',
		'to'      => '<'.'pooja@odenterprise.org'.'>',
		'cc'      => '<'.'greg@odenterprise.org'.'>',
		'subject' => "Open Data Impact Map: EDIT FOR PROFILE ${surveyId}",
		'text'    => $emailtext
	));
	// exit;
	// writeDataLog($allPostVars);
	$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; INFO; ". str_replace("\n", "||", print_r($allPostVars, true)) );
	//capture edits
	// echo "<br>"."/survey/".$lastsurvey_id."/thankyou/";
// exit;
	$app->redirect("/survey/submitted/".$lastsurvey_id);
	
});
// ************
$app->get('/:profile_id/notfound/', function ($profile_id) use ($app) {
	$content['profile_id'] = $profile_id;
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['title'] = "Open Data Enterprise Survey - Problem";
	$content['error_msg_title'] = "Organization not found.";
	$content['error_msg_details'] = "We did not find any organization for profile: $profile_id.";
	$content['language'] = "en_US";
	
	$app->view()->setData(array('content' => $content));
	$app->render('survey/tp_problem.php');
});
// **************
$app->get('/admin/survey/submitted/', function () use ($app) {
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	$params = array(
		'className' => 'org_profile',
		'query' => array(
	        'org_profile_status' => "submitted"
			)
	);
	$request = $parse->query($params);
	$request_array = json_decode($request, true);
	$org_profiles = $request_array['results'];
	// echo "<pre>"; print_r($org_profiles); echo "</pre>"; 
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";
	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('admin/tp_grid_map.php');
});
// **************
$app->get('/survey/opendata/list/new/2/', function () use ($app) {
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	$params = array(
		'className' => 'org_profile'
	);
	$request = $parse->query($params);
	$request_array = json_decode($request, true);
	$org_profiles = $request_array['results'];
	// echo "<pre>"; print_r($org_profiles); echo "</pre>"; 
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";
	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('admin/tp_grid_map.php');
});
// **************
$app->get('/survey/opendata/list/', function () use ($app) {
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	$params = array(
		'className' => 'org_profile'
	);
	$request = $parse->query($params);
	$request_array = json_decode($request, true);
	$org_profiles = $request_array['results'];
	// echo "<pre>"; print_r($org_profiles); echo "</pre>"; 
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";
	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('survey/tp_grid_map.php');
});
// **************
$app->get('/admin/survey/grid/', function () use ($app) {
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	// Initialize variables for loop
	$org_profiles = array();
	$skip = 0;
	$retrieved = 0;
	// Retrieve all records from parse.com, 1000 records at a time b/c 1000 records is the max allowed
	// Build up a single array of all retrieved records
	while ( $skip == 0 OR $retrieved > 0 ) {
		$params = array(
			'className' => 'org_profile',
			'order' => 'org_name',
			'limit' => '1000',
			'skip' => $skip
		);
		$request = $parse->query($params);
		$request_array = json_decode($request, true);
		// $org_profiles = $request_array['results'];
		$retrieved = count($request_array['results']);
		if ($retrieved > 0) {
			// Use array_merge_recursive to keep merged array flat
			$org_profiles = array_merge_recursive($org_profiles,$request_array['results']);
		}
		// echo "$retrieved ";
		// increment skip
		$skip = $skip + 1000;
	}
	// We now have all records in one big array in $org_profiles
	// echo "<pre>"; print_r($org_profiles); echo "</pre>"; 
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";
	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('admin/tp_grid.php');
});
$app->get('/admin/survey/duplicate/', function () use ($app) {
	
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	// Initialize variables for loop
	$org_profiles = array();
	$skip = 0;
	$retrieved = 0;
	// Retrieve all records from parse.com, 1000 records at a time b/c 1000 records is the max allowed
	// Build up a single array of all retrieved records
	while ( $skip == 0 OR $retrieved > 0 ) {
		$params = array(
			'className' => 'org_profile',
			'order' => 'org_name',
		    'query' => array(
				        'org_profile_status' => 'publish'
					    ),
			'limit' => '1000',
			'skip' => $skip
		);
		$request = $parse->query($params);
		$request_array = json_decode($request, true);
		// $org_profiles = $request_array['results'];
		$retrieved = count($request_array['results']);
		if ($retrieved > 0) {
			// Use array_merge_recursive to keep merged array flat
			$org_profiles = array_merge_recursive($org_profiles,$request_array['results']);
		}
		// echo "$retrieved ";
		// increment skip
		$skip = $skip + 1000;
	}
	$duplicate_list = array();
	foreach ($org_profiles as $profile){
		foreach($org_profiles as $iter){
			if ($iter['objectId'] != $profile['objectId'] &&
					$iter['org_name'] == $profile['org_name']){
				$duplicate_list[] = strval($iter['profile_id']);
			}
		}
	}
	$duplicate_list = array_unique($duplicate_list);
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";
	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles, 'duplicate_list' => $duplicate_list));
	$app->render('admin/tp_grid.php');
});
// **************
$app->post('/admin/survey/updatefield/:profile_id', function ($profile_id) use ($app) {
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	// Loop through post vars and set string values to numeric values where needed
	$allPostVars = $app->request->post();
	// print_r($allPostVars); exit;
	foreach ($allPostVars as $key => $val) {
		$field_name = $key;
		// echo "field_name: $field_name";
		switch ($field_name) {
			case "org_year_founded":
				$value = intval($val);
				break;
			case "org_profile_year":
				$value = intval($val);
				break;
			case "latitude":
				$value = floatval($val);
				break;
			case "longitude":
				$value = floatval($val);
				break;
			case "use_advocacy":
				$value = (bool)$val;
				break;
			case "use_org_opt":
				$value = (bool)$val;
				break;
			case "use_prod_srvc":
				$value = (bool)$val;
				break;
			case "use_research":
				$value = (bool)$val;
				break;
			case "use_other":
				$value = (bool)$val;
				break;
			default:
				$value = $val;
		}
	}
	$params = array(
	    'className' => 'org_profile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);
	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$org_profile = $request_decoded['results'][0];
	$objectId = $org_profile['objectId'];
	$params = array(
		'className' => 'org_profile',
		'objectId' => $objectId,
		'object' => array(
			$field_name => $value
		)
	);
	$request = $parse->update($params);
	$request_array = json_decode($request, true);
	// print_r($request);
	$org_profile[$field_name] = $value;
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id,
	        'row_type' => 'org_profile'
	    )
	);
	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	// print_r($request_decoded);
	if ( count($request_decoded['results']) == 0 ) {
		$content['flatfile_msg'] = "no match in arcgis_flatfile for ${profile_id}";
		// Note in log
		$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "No matching profile_id ${profile_id} in arcgis_flatfile" );
		exit;
	} else {
		$content['flatfile_msg'] = "Updating ".count($request_decoded['results'])." matches in arcgis_flatfile";
	}
	$arcgis_org_profile = $request_decoded['results'][0];
	$objectId = $org_profile['objectId'];
	// find all objectIds we need to update in arcgis_flatfile
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);
	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$arcgis_flatfile_objects = $request_decoded['results'];
	// update all objects in arcgis_flatfile
	foreach($arcgis_flatfile_objects as $object) {
		$params = array(
			'className' => 'arcgis_flatfile',
			'objectId' => $object['objectId'],
			'object' => array(
				$field_name => $value
			)
		);
		$request = $parse->update($params);
		$request_array = json_decode($request, true);
		$msg = "Updated arcgis_flatfile orbjectId ${object['objectId']}";
		$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "$msg" );
	}
	echo "All records updated for profile_id '${profile_id}'. ";
	// Prepare and send template result
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";
	$content['updatedAt'] = $request_array['updatedAt'];
	$content['field_name'] = $field_name;
	$content['value'] = $value;
	$content['profile_id'] =  $profile_id;
	$app->view()->setData(array('content' => $content));
	$app->render('admin/tp_udpatefield_result.php');
});
// **************
$app->get('/admin/survey/syncflatfile/changedfiles', function () use ($app) {
	// This route syncs ALL arcgis_flatfile data with any updates to org_profile data, field by field, record by record.
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	echo "Synching all org_profile data to arcgis_flatfile</br>";
	// $response->status($isPartialContent ? 206 : 200);
	flush();
	$app->redirect("/survey/admin/survey/syncflatfile/all_records"); 
});
// **************
$app->get('/admin/survey/syncflatfile/all', function () use ($app) {
	// This route syncs ALL arcgis_flatfile data with any updates to org_profile data, field by field, record by record.
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	echo "Synching all org_profile data to arcgis_flatfile</br>";
	// $response->status($isPartialContent ? 206 : 200);
	flush();
	$app->redirect("/survey/admin/survey/syncflatfile/all_records"); 
});
// **************
$app->get('/admin/survey/syncflatfile/:profile_id', function ($profile_id) use ($app) {
	// This route syncs the arcgis_flatfile data with any updates to org_profile data, field by field, record by record.
	// Requires login to access
	if ( !isset($_SESSION['username']) ) { $app->redirect("/survey/admin/login/"); }
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	// Are we synching all records or just one?
	if ( "all_records" == $profile_id ) {
		echo "Get ready to sync all records.<br />";
		$profile_ids = array('478', '479', '480', '481', '484', '511');
		// TODO: This query needs to loop to get all records past 1000 once the list grows that large
		$params = array(
			'className' => 'org_profile',
			'order' => 'org_name',
			'limit' => '1000'
		);
		$request = $parse->query($params);
		$request_array = json_decode($request, true);
		$org_profiles = $request_array['results'];
		// print_r($org_profiles);
		foreach ($org_profiles as $org_profile) {
			array_push($profile_ids, $org_profile['profile_id']);
			// echo $org_profile['profile_id']."-";
		}
	} else {
		$profile_ids = array($profile_id);
	}
foreach ($profile_ids as $profile_id) {
	# code...
	// query database for object_id
	// Retrieve org_profile
	$params = array(
	    'className' => 'org_profile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);
	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$org_profile = $request_decoded['results'][0];
	$objectId = $org_profile['objectId'];
	// find arcgis_flatfile
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id,
	        'row_type' => 'org_profile'
	    )
	);
	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	// print_r($request_decoded);
	if ( count($request_decoded['results']) == 0 ) {
		echo "<br> log no match in arcgis_flatfile for ${profile_id}";
		// Note in log
		$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "No matching profile_id ${profile_id} in arcgis_flatfile" );
		exit;
	}
	$arcgis_org_profile = $request_decoded['results'][0];
	$objectId = $org_profile['objectId'];
	// find all objectIds we need to update in arcgis_flatfile
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);
	$request = $parse->query($params);
	$request_decoded = json_decode($request, true);
	$arcgis_flatfile_objects = $request_decoded['results'];
	// Loop through fields in org_profile. Where a field is different in org_profile, update arcgis_flatfile field value
	foreach (array_keys($org_profile) as $key) {
		// ignore a few select fields
		if (in_array($key, array('objectId', 'profile_id', 'updatedAt', 'createdAt', 'date_created', 'date_modified'))) { continue; }
		// make sure undefined values don't stop us
		if (!isset($arcgis_org_profile[$key])) { $arcgis_org_profile[$key] = null; }
		
		// compare field values for updates
		if ( $org_profile[$key] != $arcgis_org_profile[$key] ) {
			$msg =  "$key<br>&nbsp; ${org_profile[$key]} | ${arcgis_org_profile[$key]} ";
			echo "<br/>$msg";
			$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "$msg" );
			// Update all arcgis_profile records parse using query by looping through the related objectIds
			foreach($arcgis_flatfile_objects as $object) {
				echo "--${object['objectId']}--";
				
				$params = array(
					'className' => 'arcgis_flatfile',
					'objectId' => $object['objectId'],
					'object' => array(
						$key => $org_profile[$key]
					)
				);
				$request = $parse->update($params);
				$request_array = json_decode($request, true);
				$msg = "Updated arcgis_flatfile orbjectId ${object['objectId']}";
				$app->log->info(date_format(date_create(), 'Y-m-d H:i:s')."; DATA_UPDATE; ". "$msg" );
				// print_r($request);
			}
		}
	}
	echo "<br><br>All records updated for profile_id '${profile_id}'.";
	flush(); // send info to screen
} // end loop of profile ids being updated
	exit;
});
// **************
$app->get('/opendata/submitted/csv', function () use ($app) {
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	$params = array(
		'className' => 'org_profile',
		'query' => array(
	        'org_profile_status' => "submitted"
			)
	);
	$request = $parse->query($params);
	$request_array = json_decode($request, true);
	$org_profiles = $request_array['results'];
	// echo "<pre>"; print_r($org_profiles); echo "</pre>";
	$content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
	$content['surveyName'] = "opendata";
	$content['title'] = "Open Data Enterprise Survey - Recently Submitted";
	$content['language'] = "en_US";
	$app->view()->setData(array('content' => $content, 'org_profiles' => $org_profiles));
	$app->render('survey/tp_csv.php');
});
// **************
$app->get('/showduplicates', function () use ($app) {
	$db = connect_db(); 
	$org_profile_query="SELECT profile_id, org_name, createdAt FROM org_profiles where org_profile_status='publish' ORDER BY profile_id DESC";
	$stmt = $db->prepare($org_profile_query); 	
	$stmt->execute();
	$org_profile = $stmt->fetchAll();

	$names = array();

	foreach ($org_profile as $item){
		if (in_array($item["org_name"], $names)) {
			echo strval($item["profile_id"]) . ": " . $item["org_name"] . ", inserted on " . strval($item["createdAt"]);
			echo "<br>";
		}
		else {
			array_push($names, $item["org_name"]);
		}		
	}
});

$app->get('/showdata', function() use($app) {

	$db = connect_db(); 
	$org_profile_query="SELECT * FROM org_profiles as p LEFT JOIN org_locations as l ON p.location_id = l.location_id
														LEFT JOIN org_country_info as c ON p.country_id = c.country_id
														LEFT JOIN data_applications as a ON p.profile_id = a.profile_id
														ORDER BY p.profile_id DESC";
	$stmt = $db->prepare($org_profile_query); 
	$stmt->bindParam("pid", $profile_id);
	$stmt->execute();
	$org_profile = $stmt->fetchAll();

	foreach ($org_profile as $item){
		echo strval($item["profile_id"]) . ": " . $item["org_name"] . ", inserted on " . strval($item["createdAt"]);
		echo "<br>";
	}
});

// ************** on development.. by Myeong .. .
$app->get('/data/flatfile.json', function () use ($app) {

	$db = connect_db(); 
	$db -> exec("set names utf8");
	$org_profile_query="SELECT * FROM org_profiles as p LEFT JOIN org_locations as l ON p.location_id = l.location_id
														LEFT JOIN org_country_info as c ON p.country_id = c.country_id
														LEFT JOIN data_applications as a ON p.profile_id = a.profile_id														
														where p.org_profile_status='publish'";
	$stmt = $db->prepare($org_profile_query); 	
	$stmt->execute();
	$org_profile = $stmt->fetchAll();

	$final_array = array();
	
	// Data Use
	foreach ($org_profile as $item){
		$temp = array();

		$createdAt = explode(" ",  $item["createdAt"]);
		$updatedAt = explode(" ",  $item["updatedAt"]);
		$temp["createdAt"]  =  $createdAt[0];		
		$temp["industry_id"] = $item["industry_id"];
		$temp["industry_other"] = $item["industry_other"];
		$temp["latitude"] = (floatval($item["latitude"]) == 0) ? floatval($item['c_lat']) : floatval($item["latitude"]);
		$temp["longitude"] = (floatval($item["longitude"]) == 0) ? floatval($item['c_lon']) : floatval($item["longitude"]);
		$temp["no_org_url"] = intval($item["no_org_url"]);
		$temp["org_description"] = $item["org_description"];
		$temp["org_greatest_impact"] = $item["org_greatest_impact"];
		$temp["org_greatest_impact_detail"] = $item["org_greatest_impact_detail"];
		$temp["org_hq_city"] = $item["org_hq_city"];
		// $temp["org_hq_city_locode"] = null;
		$temp["org_hq_country"] = $item["org_hq_country"];
		$temp["org_hq_country_income"] = $item["org_hq_country_income"];
		$temp["org_hq_country_income_code"] = $item["org_hq_country_income_code"];
		$temp["org_hq_country_locode"] = $item["ISO2"];
		$temp["org_hq_country_region"] = $item["org_hq_country_region"];
		// $temp["org_hq_country_region_code"] = $item["org_hq_country_region_code"];
		$temp["org_hq_st_prov"] = $item["org_hq_st_prov"];
		$temp["org_name"] = $item["org_name"];
		$temp["org_open_corporates_id"] = null;
		$temp["org_profile_category"] = $item["org_profile_category"];
		$temp["org_profile_src"] = $item["org_profile_src"];
		$temp["org_profile_status"] = $item["org_profile_status"];
		$temp["org_profile_year"] = intval($item["org_profile_year"]);
		$temp["org_size_id"] = $item["org_size"];
		$temp["org_type"] = $item["org_type"];
		$temp["org_type_other"] = $item["org_type_other"];
		$temp["org_url"] = $item["org_url"];
		$temp["org_year_founded"] = intval($item["org_year_founded"]);
		$temp["profile_id"] = intval($item["profile_id"]);
		$temp["row_type"] = "org_profile";
		$temp["updatedAt"] = $updatedAt[0];
		$temp["use_advocacy"] = intval($item["advocacy"]);
		$temp["use_advocacy_desc"] = $item["advocacy_desc"];
		$temp["use_org_opt"] = intval($item["org_opt"]);
		$temp["use_org_opt_desc"] = $item["org_opt_desc"];
		$temp["use_other"] = intval($item["use_other"]);
		$temp["use_other_desc"] = $item["use_other_desc"];
		$temp["use_prod_srvc"] = intval($item["prod_srvc"]);
		$temp["use_prod_srvc_desc"] = $item["prod_srvc_desc"];
		$temp["use_research"] = intval($item["research"]);
		$temp["use_research_desc"] = $item["research_desc"];
		$temp["date_created"] = $createdAt[0];
		$temp["date_modified"] = $updatedAt[0];
		$temp["eligibility"] = "YY";
		$temp["org_additional"] = $item["org_additional"];
		$temp["org_confidence"] = intval($item["org_confidence"]);
		// $temp["data_country_count"] = intval($item["data_country_count"]);
		$temp["machine_read"] = $item["machine_read"];
		array_push($final_array, $temp);

		$data_use_query="SELECT * FROM org_data_use as u LEFT JOIN org_country_info as c ON u.src_country_id = c.country_id
						where profile_id = :pid";
		$stmt2 = $db->prepare($data_use_query); 	
		$stmt2->bindParam("pid", $item["profile_id"]);
		$stmt2->execute();
		$data_use = $stmt2->fetchAll();

		foreach ($data_use as $use){

			$use_temp = array();
			$createdAt = explode(" ",  $item["createdAt"]);
			$updatedAt = explode(" ",  $item["updatedAt"]);

			$use_temp["createdAt"]  =  $createdAt[0];			
			$use_temp["industry_id"] = $item["industry_id"];
			$use_temp["industry_other"] = $item["industry_other"];
			$use_temp["latitude"] = (floatval($item["latitude"]) == 0) ? floatval($item['c_lat']) : floatval($item["latitude"]);
			$use_temp["longitude"] = (floatval($item["longitude"]) == 0) ? floatval($item['c_lon']) : floatval($item["longitude"]);
			$use_temp["no_org_url"] = intval($item["no_org_url"]);
			$use_temp["org_description"] = $item["org_description"];
			$use_temp["org_greatest_impact"] = $item["org_greatest_impact"];
			$use_temp["org_greatest_impact_detail"] = $item["org_greatest_impact_detail"];
			$use_temp["org_hq_city"] = $item["org_hq_city"];
			// $use_temp["org_hq_city_locode"] = null;
			$use_temp["org_hq_country"] = $item["org_hq_country"];
			$use_temp["org_hq_country_income"] = $item["org_hq_country_income"];
			$use_temp["org_hq_country_income_code"] = $item["org_hq_country_income_code"];
			$use_temp["org_hq_country_locode"] = $item["ISO2"];
			$use_temp["org_hq_country_region"] = $item["org_hq_country_region"];
			// $use_temp["org_hq_country_region_code"] = $item["org_hq_country_region_code"];
			$use_temp["org_hq_st_prov"] = $item["org_hq_st_prov"];
			$use_temp["org_name"] = $item["org_name"];
			$use_temp["org_open_corporates_id"] = null;
			$use_temp["org_profile_category"] = $item["org_profile_category"];
			$use_temp["org_profile_src"] = $item["org_profile_src"];
			$use_temp["org_profile_status"] = $item["org_profile_status"];
			$use_temp["org_profile_year"] = intval($item["org_profile_year"]);
			$use_temp["org_size_id"] = $item["org_size"];
			$use_temp["org_type"] = $item["org_type"];
			$use_temp["org_type_other"] = $item["org_type_other"];
			$use_temp["org_url"] = $item["org_url"];
			$use_temp["org_year_founded"] = intval($item["org_year_founded"]);
			$use_temp["profile_id"] = intval($item["profile_id"]);
			$use_temp["row_type"] = "data_use";
			$use_temp["updatedAt"] = $updatedAt[0];
			$use_temp["use_advocacy"] = intval($item["advocacy"]);
			$use_temp["use_advocacy_desc"] = $item["advocacy_desc"];
			$use_temp["use_org_opt"] = intval($item["org_opt"]);
			$use_temp["use_org_opt_desc"] = $item["org_opt_desc"];
			$use_temp["use_other"] = intval($item["use_other"]);
			$use_temp["use_other_desc"] = $item["use_other_desc"];
			$use_temp["use_prod_srvc"] = intval($item["prod_srvc"]);
			$use_temp["use_prod_srvc_desc"] = $item["prod_srvc_desc"];
			$use_temp["use_research"] = intval($item["research"]);
			$use_temp["use_research_desc"] = $item["research_desc"];
			$use_temp["date_created"] = $createdAt[0];
			$use_temp["date_modified"] = $updatedAt[0];
			$use_temp["eligibility"] = "YY";
			$use_temp["org_additional"] = $item["org_additional"];
			$use_temp["org_confidence"] = intval($item["org_confidence"]);
			// $use_temp["data_country_count"] = intval($item["data_country_count"]);
			$use_temp["machine_read"] = $item["machine_read"];
			$use_temp["data_src_country_locode"] = $use["ISO2"];
	      	$use_temp["data_src_country_name"] = $use["org_hq_country"];
	      	$use_temp["data_src_gov_level"]= $use["data_src_gov_level"];
	      	$use_temp["data_type"]= $use["data_type"];
	      	$use_temp["data_use_type_other"] = $use["data_use_type_other"];
	      	array_push($final_array, $use_temp);
	      }

	}

	$jsonArray = array("results" => $final_array);
	echo json_encode($jsonArray);

	return true;
});
/*
 * ArcGIS Online routes
 */
// **************
$app->get('/data/agol/addFeatures/json/:profile_id', function ($profile_id) use ($app) {
	$parse = new parseRestClient(array(
		'appid' => PARSE_APPLICATION_ID,
		'restkey' => PARSE_API_KEY
	));
	// retrieve the record from parse
	// Retrieve org_data_use
	$params = array(
	    'className' => 'arcgis_flatfile',
	    'query' => array(
	        'profile_id' => $profile_id
	    )
	);
	$request = $parse->query($params);
	// print_r($request);
	$request_array = json_decode($request, true);
	$arcgis_rows = array( $request_array['results'][0] );
	array_walk($arcgis_rows, 'addFeaturesFormatting');
	// Let's convert to json and send using expected format with 'results' key
	$arcgis_flatfile = array( array("attributes" => $arcgis_rows[0]) ) ;
	// // $arcgis_flatfile = array("results" => array_slice($arcgis_rows,1,2));
	header('Content-Type: application/json');
	echo json_pretty(json_encode($arcgis_flatfile));
	return true;
});
// *****************
$app->get('/argis/auth/', function () use ($app) {
	$params = array(
	    'client_id' => ArcGIS_CLIENT_ID,
	    'client_secret' => ArcGIS_CLIENT_SECRET,
	    'grant_type' => 'client_credentials',
	    'f' => 'json'
	);
	try {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "https://www.arcgis.com/sharing/oauth2/token/");
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    $response = curl_exec($ch);
	} catch (Exception $e) {
	    error_log($e->getMessage(), 0);
	}
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$body = substr($response, $header_size);
	$json = json_decode($body, true);
	$token = $json['access_token'];
	echo $token;
});
// *****************
$app->get('/argis/geoservice/', function () use ($app) {
	$params = array(
	    'client_id' => ArcGIS_CLIENT_ID,
	    'client_secret' => ArcGIS_CLIENT_SECRET,
	    'grant_type' => 'client_credentials',
	    'f' => 'json'
	);
	try {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "https://www.arcgis.com/sharing/oauth2/token/");
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    $response = curl_exec($ch);
	} catch (Exception $e) {
	    error_log($e->getMessage(), 0);
	}
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$body = substr($response, $header_size);
	$json = json_decode($body, true);
	$token = $json['access_token'];
	echo $token;
});
/*
 * Development routes
 */
// ************
// ************
$app->run();
?>
