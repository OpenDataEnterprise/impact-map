<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// 1-3 years query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Consumer services"
			and org_year_founded > 2012
			-- and org_year_founded > 2005
			-- and org_year_founded < 2013
			-- and org_year_founded < 2006
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_age = "1-3 years";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}


// 4-10 years query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Consumer services"
			-- and org_year_founded > 2012
			and org_year_founded > 2005
			and org_year_founded < 2013
			-- and org_year_founded < 2006
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_age = "4-10 years";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	// 10 years query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Consumer services"
			-- and org_year_founded > 2012
			-- and org_year_founded > 2005
			-- and org_year_founded < 2013
			and org_year_founded < 2006
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_age = "10+ years";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	echo json_encode($data);
?>