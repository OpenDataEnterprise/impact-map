<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

$array = array('Agriculture','Arts, culture and tourism','Business, research and consulting','Consumer','Education','Energy and climate','Finance and insurance','Governance','Healthcare','Housing, construction & real estate','IT and geospatial','Media and communications','Transportation and logistics');

for ($i=0; $i<13; $i++) {

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "Europe & Central Asia"
			and industry_id = "' .$array[$i]. '"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		if ( (int)$row["count(distinct(org_name))"] != 0 ) {
		$obj = new stdClass();
		$obj->sector = $array[$i];
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		}
	}
}
	

	echo json_encode($data);
?>