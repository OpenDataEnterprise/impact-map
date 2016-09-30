<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// 1-10 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business and legal services"
			and org_size = "1 to 10";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business, research and consulting"
			and org_size = "1 to 10";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	$obj = new stdClass();
		$obj->org_size = "1 to 10";
		$obj->number = $num;
		$data[] = $obj;


// 11-50 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business and legal services"
			and org_size = "11 to 50";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business, research and consulting"
			and org_size = "11 to 50";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	$obj = new stdClass();
		$obj->org_size = "11 to 50";
		$obj->number = $num;
		$data[] = $obj;

// 51-200 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business and legal services"
			and org_size = "51 to 200";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business, research and consulting"
			and org_size = "51 to 200";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	$obj = new stdClass();
		$obj->org_size = "51 to 200";
		$obj->number = $num;
		$data[] = $obj;

// 201-1000 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business and legal services"
			and org_size ="201-1000";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business, research and consulting"
			and org_size ="201-1000";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business and legal services"
			and org_size ="1000";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business, research and consulting"
			and org_size ="1000";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2 + $string3 + $string4;

	$obj = new stdClass();
		$obj->org_size = "201 to 1000";
		$obj->number = $num;
		$data[] = $obj;

// 1000 query
	// $sql = 'SELECT count(distinct(org_name)) as "East Asia & Pacific" from org_profiles, org_locations_info, org_country_info
	// 		where org_loc_id = org_locations_info.object_id
	// 		and org_locations_info.country_id = org_country_info.country_id
	// 		and org_hq_country_region = "East Asia & Pacific"
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
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business and legal services"
			and org_size ="1000+";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Business, research and consulting"
			and org_size ="1000+";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	$obj = new stdClass();
		$obj->org_size = "1000+";
		$obj->number = $num;
		$data[] = $obj;

	// $result = 
	// echo $string;
	// var_dump($data);
	// var_dump(json_encode($data));
	echo json_encode($data);
?>	