<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// 1-10 query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			and org_size = "1-10"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_size = "1-10";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'South Asia'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
	}

	// echo $string;

// 11-50 query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			and org_size = "11-50"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_size = "11-50";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	// echo $string;

// 51-200 query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			and org_size = "51-200"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_size = "51-200";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	// echo $string;

// 201-1000 query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			and org_size = "201-1000"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_size = "201-1000";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	// echo $string;

// 1000 query
	// $sql = 'SELECT count(distinct(org_name)) as "South Asia" from org_profiles, org_locations, org_country_info
	// 		where org_profiles.location_id = org_locations.location_id
	// 		and org_locations.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "South Asia"
	// 		and org_size = "1000"
	// 		and org_profile_status = "publish";';

	// if(!$result = $db->query($sql)){
	//     die('There was an error running the query [' . $db->error . ']');
	// }

	// while($row = $result->fetch_assoc()){
	// 	// $string = $row["count(distinct(org_name))"];
	// 	$data[] = $row;
	// }

	// echo $string;

// 1000+ query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			and org_size = "1000+"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_size = "1000+";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	// $result = 
	// echo $string;
	// var_dump($data);
	// var_dump(json_encode($data));
	echo json_encode($data);
?>