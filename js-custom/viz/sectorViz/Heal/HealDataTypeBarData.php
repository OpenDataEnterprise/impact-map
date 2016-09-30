<?php  


	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// 1 Geospatial Mapping
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Geospatial/mapping'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Geospatial'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Geospatial/mapping'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Geospatial'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Geospatial/mapping'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string5 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Geospatial'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string6 = $row["count(distinct(org_data_use.profile_id))"];
	}


	$num = $string1 + $string2 + $string3 + $string4 + $string5 + $string6;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Geospatial";
		$obj->number = $num;
		$data[] = $obj;
	}

// 2 Environment
	// data type environment
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Environment'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Environment'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Environment'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Environment";
		$obj->number = $num;
		$data[] = $obj;
	}

	///// data type weather

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Weather'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Weather'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string5 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Weather'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string6 = $row["count(distinct(org_data_use.profile_id))"];
	}


	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Weather";
		$obj->number = $num;
		$data[] = $obj;
	}
	
// 3 Transportation
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Transportation'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Transportation'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Transportation'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Transportation";
		$obj->number = $num;
		$data[] = $obj;
	}
	
// 4 Government operations
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Government operations'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Government operations'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Government operations'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Government Operations";
		$obj->number = $num;
		$data[] = $obj;
	}
			

// 5 'Demographics and social'
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Demographics and social'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Demographics and social'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Demographics and social'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Demographic & Social";
		$obj->number = $num;
		$data[] = $obj;
	}

			

// 6 'Housing'
	// Energy
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Housing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Housing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Housing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Housing";
		$obj->number = $num;
		$data[] = $obj;
	}

			

// 7 'Economics '
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Economics'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Economics'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Economics'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Economic";
		$obj->number = $num;
		$data[] = $obj;
	}

			

// 8 'Education'
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Education'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Education'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Education'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Education";
		$obj->number = $num;
		$data[] = $obj;
	}

			

// 9 'Health/healthcare'
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Health/healthcare'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Health/healthcare'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Health/healthcare'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Health";
		$obj->number = $num;
		$data[] = $obj;
	}

			

// 10 Finance
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Finance'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Finance'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Finance'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Finance";
		$obj->number = $num;
		$data[] = $obj;
	}

			

// 11 Public Safety
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Public safety'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Public safety'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Public safety'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Public Safety";
		$obj->number = $num;
		$data[] = $obj;
	}
	
			

// 12 Energy
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Energy'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Energy'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Energy'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Energy";
		$obj->number = $num;
		$data[] = $obj;
	}
			

// 13 Legal
// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Legal'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Legal'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Legal'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Legal";
		$obj->number = $num;
		$data[] = $obj;
	}
			

// 14 Tourism
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Tourism'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Tourism'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Tourism'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Tourism";
		$obj->number = $num;
		$data[] = $obj;
	}
			

// 15 Manufacturing 
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Manufacturing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Manufacturing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Manufacturing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Manufacturing";
		$obj->number = $num;
		$data[] = $obj;
	}
			

// 16 'Science and research'
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Science and research'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Science and research'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Science and research'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Science & Research";
		$obj->number = $num;
		$data[] = $obj;
	}
			

// // 17 'Other'
// 	// Healthcare
// 	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
// 		where org_data_use.profile_id = org_profiles.profile_id
// 		and industry_id = 'Healthcare'
// 		and data_type = 'Other'";

// 	if(!$result = $db->query($sql)){
// 	    die('There was an error running the query [' . $db->error . ']');
// 	}

// 	while($row = $result->fetch_assoc()){
// 		$string1 = $row["count(distinct(org_data_use.profile_id))"];
// 	}

// 	// Water and sanitation
// 	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
// 		where org_data_use.profile_id = org_profiles.profile_id
// 		and industry_id = 'Water and sanitation'
// 		and data_type = 'Other'";

// 	if(!$result = $db->query($sql)){
// 	    die('There was an error running the query [' . $db->error . ']');
// 	}

// 	while($row = $result->fetch_assoc()){
// 		$string2 = $row["count(distinct(org_data_use.profile_id))"];
// 	}

// 	// Scientific research
// 	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
// 		where org_data_use.profile_id = org_profiles.profile_id
// 		and industry_id = 'Scientific research'
// 		and data_type = 'Other'";

// 	if(!$result = $db->query($sql)){
// 	    die('There was an error running the query [' . $db->error . ']');
// 	}

// 	while($row = $result->fetch_assoc()){
// 		$string3 = $row["count(distinct(org_data_use.profile_id))"];
// 	}


// 	// sum it up and check if zero
// 	$num = $string1 + $string2 + $string3;

// 	if ($num != 0) {
// 		$obj = new stdClass();
// 		$obj->app_type = "Other";
// 		$obj->number = $num;
// 		$data[] = $obj;
// 	}

// 18 'Consumer'
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Consumer'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Consumer'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Consumer'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Consumer";
		$obj->number = $num;
		$data[] = $obj;
	}

// 19 'Business'
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Business'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Business'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Business'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Business";
		$obj->number = $num;
		$data[] = $obj;
	}

// 20 'International/global development'
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'International/global development'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'International/global development'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'International/global development'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "International Development";
		$obj->number = $num;
		$data[] = $obj;
	}

// 21 Agriculture
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Agriculture'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Agriculture'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Agriculture'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Agriculture";
		$obj->number = $num;
		$data[] = $obj;
	}

// 22 'Arts and culture'
	// Healthcare
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Healthcare'
		and data_type = 'Arts and culture'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Water and sanitation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Water and sanitation'
		and data_type = 'Arts and culture'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Scientific research
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Scientific research'
		and data_type = 'Arts and culture'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
	}


	// sum it up and check if zero
	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Arts & Culture";
		$obj->number = $num;
		$data[] = $obj;
	}


	echo json_encode($data);



?>