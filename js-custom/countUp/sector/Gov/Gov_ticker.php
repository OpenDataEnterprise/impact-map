<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// query one
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id ="Governance";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// var_dump($row);
		$string1 = $row["count(distinct(org_name))"];
	}

// query one
	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id ="Security and public safety";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// var_dump($row);
		$string2 = $row["count(distinct(org_name))"];
	}

	// $num = $stirng + 5;
	// echo $row;
	$string = $string1 + $string2;
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