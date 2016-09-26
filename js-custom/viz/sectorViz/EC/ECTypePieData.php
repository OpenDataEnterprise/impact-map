<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// for profit query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Energy"
			and org_type = "For-profit";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Environment"
			and org_type = "For-profit";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Mining/manufacturing"
			and org_type = "For-profit";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Weather"
			and org_type = "For-profit";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2 + $string3 + $string4;

	$obj = new stdClass();
		$obj->org_type = "For Profit";
		$obj->number = $num;
		$data[] = $obj;


// developer group query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Energy"
			and org_type = "Developer group";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Environment"
			and org_type = "Developer group";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Mining/manufacturing"
			and org_type = "Developer group";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Weather"
			and org_type = "Developer group";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2 + $string3 + $string4;

	$obj = new stdClass();
		$obj->org_type = "Developer Group";
		$obj->number = $num;
		$data[] = $obj;

// nonprofit query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Energy"
			and org_type = "Nonprofit";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Environment"
			and org_type = "Nonprofit";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Mining/manufacturing"
			and org_type = "Nonprofit";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Weather"
			and org_type = "Nonprofit";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2 + $string3 + $string4;

	$obj = new stdClass();
		$obj->org_type = "Nonprofit";
		$obj->number = $num;
		$data[] = $obj;

// other query
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Energy"
			and org_type = "Other";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Environment"
			and org_type = "Other";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Mining/manufacturing"
			and org_type = "Other";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id = "Weather"
			and org_type = "Other";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2 + $string3 + $string4;

	$obj = new stdClass();
		$obj->org_type = "Other";
		$obj->number = $num;
		$data[] = $obj;

	echo json_encode($data);
?>	