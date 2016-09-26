<?php  
	include_once("../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// North america
	// $sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "North America"
	// 		and org_profile_status = "publish";';
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "North America"
			and org_profile_status = "publish";';

	if (!$result = $db->query($sql)) {
	    die('There was an error running the query [' . $db->error . ']');
	}

	while ($row = $result->fetch_assoc()) {
		$obj = new stdClass();
		$obj->region = "North America";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// South Asia
	// $sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "South Asia"
	// 		and org_profile_status = "publish";';
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->region = "South Asia";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// Europe & Central Asia
	// $sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "Europe & Central Asia"
	// 		and org_profile_status = "publish";';
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "Europe & Central Asia"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->region = "Europe & Central Asia";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// Middle East & North Africa
	// $sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "Middle East & North Africa"
	// 		and org_profile_status = "publish";';
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "Middle East & North Africa"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->region = "Middle East & North Africa";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}
	
// East Asia & Pacific
	// $sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "East Asia & Pacific"
	// 		and org_profile_status = "publish";';
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->region = "East Asia & Pacific";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// Sub-Saharan Africa
	// $sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "Sub-Saharan Africa"
	// 		and org_profile_status = "publish";';
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "Sub-Saharan Africa"
			and org_profile_status = "publish";';


	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->region = "Sub-Saharan Africa";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// Latin America & Caribbean
	// $sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "Latin America & Caribbean"
	// 		and org_profile_status = "publish";';
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "Latin America & Caribbean"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->region = "Latin America & Caribbean";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}
	
	

	echo json_encode($data);
?>