<?php  


	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// 1 Geospatial Mapping
	
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Geospatial/mapping'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
		// echo var_dump($row);
	}

	

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Geospatial'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Research and consulting
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Geospatial/mapping'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
		// echo var_dump($row);
	}

	

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Geospatial'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2 + $string3 + $string4;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Geospatial & Mapping";
		$obj->number = $num;
		$data[] = $obj;
	}

// 2 Environment
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Environment'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Weather'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	// Research and consulting
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Environment'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_data_use.profile_id))"];
		// echo var_dump($row);
	}

	

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Weather'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2 + $string3 + $string4;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->app_type = "Environment";
		$obj->number = $num;
		$data[] = $obj;
	}
	
// 3 Transportation
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Transportation'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Transportation'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
		if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Transportation";
			$obj->number = $num;
			$data[] = $obj;}
	
// 4 Government operations
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Government operations'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Government operations'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Government Operations";
			$obj->number = $num;
			$data[] = $obj;}
			

// 5 'Demographics and social'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Demographics and social'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Demographics and social'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Demographics & Social";
			$obj->number = $num;
			$data[] = $obj;}

			

// 6 'Housing'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Housing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Housing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;

	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Housing";
			$obj->number = $num;
			$data[] = $obj;}

			

// 7 'Economics '
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Economics'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Economics'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;

	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Economics";
			$obj->number = $num;
			$data[] = $obj;}

			

// 8 'Education'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Education'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Education'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Education";
			$obj->number = $num;
			$data[] = $obj;}

			

// 9 'Health/healthcare'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Health/healthcare'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Health/healthcare'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Health";
			$obj->number = $num;
			$data[] = $obj;}

			

// 10 Finance
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Finance'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Finance'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Finance";
			$obj->number = $num;
			$data[] = $obj;}

			

// 11 Public Safety
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Public safety'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Public safety'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Public Safety";
			$obj->number = $num;
			$data[] = $obj;}
	
			

// 12 Energy
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Energy'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Energy'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Energy";
			$obj->number = $num;
			$data[] = $obj;}
			

// 13 Legal
$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Legal'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Legal'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Legal";
			$obj->number = $num;
			$data[] = $obj;}
			

// 14 Research and consulting
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Research and consulting'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Research and consulting'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Research & consulting";
			$obj->number = $num;
			$data[] = $obj;}
			

// 15 Manufacturing 
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Manufacturing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Manufacturing'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Manufacturing";
			$obj->number = $num;
			$data[] = $obj;}
			

// 16 'Science and research'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Science and research'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Science and research'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Science & Research";
			$obj->number = $num;
			$data[] = $obj;}
			

// 17 'Other'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Other'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Other'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Other";
			$obj->number = $num;
			$data[] = $obj;}

// 18 'Consumer'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Consumer'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Consumer'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Consumer";
			$obj->number = $num;
			$data[] = $obj;}

// 19 'Business'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Business'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Business'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Business";
			$obj->number = $num;
			$data[] = $obj;}

// 20 'International/global development'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'International/global development'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'International/global development'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "International Development";
			$obj->number = $num;
			$data[] = $obj;}

// 21 Agriculture
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Agriculture'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Agriculture'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Agriculture";
			$obj->number = $num;
			$data[] = $obj;}

// 22 'Business and legal services'
	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Business and legal services'
		and data_type = 'Business and legal services'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$sql = "SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = 'Research and consulting'
		and data_type = 'Business and legal services'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_data_use.profile_id))"];
	}

	$num = $string1 + $string2;
	if ($num != 0) {$obj = new stdClass();
			$obj->app_type = "Business & Legal services";
			$obj->number = $num;
			$data[] = $obj;}


	echo json_encode($data);



?>