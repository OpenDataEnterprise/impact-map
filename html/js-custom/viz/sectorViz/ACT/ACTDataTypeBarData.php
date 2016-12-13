<?php  


	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}


	$array = array('Agriculture','Arts and culture','Business','Consumer','Demographic and social','Economic','Education','Energy','Environment','Finance','Geospatial','Government operations','Health/healthcare','Housing','International development','Legal','Public safety','Science and research','Tourism','Transportation','Weather');


	for ($i=0; $i<22; $i++) {

	$sql = 'SELECT count(distinct(org_data_use.profile_id)) from org_data_use, org_profiles
		where org_data_use.profile_id = org_profiles.profile_id
		and industry_id = "Arts, culture and tourism"
		and data_type = "' .$array[$i]. '"
		and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		if ((int)$row["count(distinct(org_data_use.profile_id))"] != 0) {
			$obj = new stdClass();
			if ($array[$i] == "Health/healthcare") {
				$obj->app_type = "Health";
			} else {
				$obj->app_type = $array[$i];
			}
			$obj->number = (int)$row["count(distinct(org_data_use.profile_id))"];
			$data[] = $obj;
	}}

}

	echo json_encode($data);


?>