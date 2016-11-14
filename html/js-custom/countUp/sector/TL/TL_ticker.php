<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id ="Transportation and logistics";';

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