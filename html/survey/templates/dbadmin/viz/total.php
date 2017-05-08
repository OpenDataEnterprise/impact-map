<?php  
	define("DBHOST", "localhost");
	define("DBNAME", "ode_survey");
	define("DBUSER", "root");
	define("DBPASS", "Sep@2016");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$sql = 'SELECT count(*) as count
			from org_profiles
			where org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string = $row["count"];
	}

	echo $string;
?>