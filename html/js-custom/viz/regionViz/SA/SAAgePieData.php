<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// 1-3 years query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_locations.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			and org_year_founded > 2012
			-- and org_year_founded > 2005
			-- and org_year_founded < 2013
			-- and org_year_founded < 2006
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_age = "1-3 years";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'South Asia'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
	}

	// echo $string;

// 4-10 years query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_locations.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			-- and org_year_founded > 2012
			and org_year_founded > 2005
			and org_year_founded < 2013
			-- and org_year_founded < 2006
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_age = "4-10 years";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'South Asia'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
	}

	// echo $string;

	// 10 years query
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_locations.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "South Asia"
			and org_year_founded > 2012
			-- and org_year_founded > 2005
			-- and org_year_founded < 2013
			-- and org_year_founded < 2006
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		$obj = new stdClass();
		$obj->org_age = "10+ years";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'South Asia'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
	}

	// echo $string;
	echo json_encode($data);
?>