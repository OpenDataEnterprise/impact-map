<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

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
		// var_dump($row);
		$string = $row["count(distinct(org_name))"];
	}

	// $num = $stirng + 5;
	// echo $row;
	echo $string;
	// echo $num?;
	// $eval = is_string($isString);

	// if ($eval) {
	// 	echo "yes";
	// } else {
	// 	echo "no";
	// }


	// $row = $result->fetch_assoc();
	// var_dump($result);
	// echo json_encode($row);
	// print $result;
?>