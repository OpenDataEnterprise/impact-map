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
			and industry_id ="Arts and culture";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// var_dump($row);
		$string1 = $row["count(distinct(org_name))"];
	}
// echo $string1;

// query two
$sql = 'SELECT count(distinct(org_name))
			from org_profiles
			where org_profile_status = "publish"
			and industry_id ="Tourism";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// var_dump($row);
		$string2 = $row["count(distinct(org_name))"];
	}
// echo $string2;

$string = $string1 + $string2;

	echo $string;

?>