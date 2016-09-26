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
			and industry_id = "Education"
			and org_size ="1-10";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "1-10";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	


// 11-50 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Education"
			and org_size ="11-50";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "11-50";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// 51-200 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Education"
			and org_size ="51-200";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "51-200";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

// 201-1000 query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Education"
			and org_size ="201-1000";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = (int)$row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Education"
			and org_size ="1000";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = (int)$row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	$obj = new stdClass();
		$obj->org_size = "201-1000";
		$obj->number = $num;
		$data[] = $obj;

// 1000+ query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Education"
			and org_size ="1000+";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$obj = new stdClass();
		$obj->org_size = "1000+";
		$obj->number = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
	}

	echo json_encode($data);
?>	