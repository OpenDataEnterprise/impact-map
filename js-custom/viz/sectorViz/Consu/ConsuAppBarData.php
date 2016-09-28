<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// Research
	$sql = 'SELECT count(distinct(org_name))
		from org_profiles, data_applications
		where org_profile_status = "publish"
		and industry_id = "Consumer services"
		and org_profiles.profile_id = data_applications.profile_id
		and data_applications.research = 1;';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		if ((int)$row["count(distinct(org_name))"] != 0) {
		$obj = new stdClass();
		$obj->app_type = "Research";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}}
	

// Product and services
	$sql = 'SELECT count(distinct(org_name))
		from org_profiles, data_applications
		where org_profile_status = "publish"
		and industry_id = "Consumer services"
		and org_profiles.profile_id = data_applications.profile_id
		and data_applications.prod_srvc = 1;';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		if ((int)$row["count(distinct(org_name))"] != 0) {
		$obj = new stdClass();
		$obj->app_type = "Development of Products/Services";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}}
	

// Organizational Optimization
	$sql = 'SELECT count(distinct(org_name))
		from org_profiles, data_applications
		where org_profile_status = "publish"
		and industry_id = "Consumer services"
		and org_profiles.profile_id = data_applications.profile_id
		and data_applications.org_opt = 1;';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		if ((int)$row["count(distinct(org_name))"] != 0) {
		$obj = new stdClass();
		$obj->app_type = "Organizational Optimization";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}}
	

// Advocacy
	$sql = 'SELECT count(distinct(org_name))
		from org_profiles, data_applications
		where org_profile_status = "publish"
		and industry_id = "Consumer services"
		and org_profiles.profile_id = data_applications.profile_id
		and data_applications.advocacy = 1;';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		if ((int)$row["count(distinct(org_name))"] != 0) {
		$obj = new stdClass();
		$obj->app_type = "Advocacy";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}}
	

// Other
	// $sql = 'SELECT count(distinct(org_name))
	// 	from org_profiles, data_applications
	// 	where org_profile_status = "publish"
	// 	and industry_id = "Consumer services"
	// 	and org_profiles.profile_id = data_applications.profile_id
	// 	and data_applications.use_other = 1;';

	// if(!$result = $db->query($sql)){
	//     die('There was an error running the query [' . $db->error . ']');
	// }

	// while($row = $result->fetch_assoc()){
	// 	if ((int)$row["count(distinct(org_name))"] != 0) {
	// 	$obj = new stdClass();
	// 	$obj->app_type = "Other";
	// 	$obj->number = (int)$row["count(distinct(org_name))"];
	// 	$data[] = $obj;
	// }}


	echo json_encode($data);
?>