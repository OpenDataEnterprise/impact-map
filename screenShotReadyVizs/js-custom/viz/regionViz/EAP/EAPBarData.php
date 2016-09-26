<?php  
	include_once("../../../db_config.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

//  1 IT and Geospatial
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Data/information technology"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Geospatial/mapping"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	if ($num != 0) {
	$obj = new stdClass();
		$obj->sector = "IT & Geospatial";
		$obj->orgs = $num;
		$data[] = $obj;
	}

	// echo $string;

// 2 agriculture
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Agriculture"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		if ( (int)$row["count(distinct(org_name))"] != 0 ) {
		$obj = new stdClass();
		$obj->sector = "Agriculture";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'East Asia & Pacific'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
		}
	}

	// echo $string;

// 3 Business research and consulting
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Business and legal services"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Research and consulting"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->sector = "Business, Research & Consulting";
		$obj->orgs = $num;
		$data[] = $obj;
	}
	

	// echo $string;

// 4 Energy and Climate
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Energy"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Environment"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Mining/manufacturing"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Weather"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string4 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2 + $string3 + $string4;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->sector = "Energy & Climate";
		$obj->orgs = $num;
		$data[] = $obj;
	}
	

	// echo $string;

// 5 Finance investment and insurance
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Finance and investment"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Insurance"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->sector = "Finance, Investment & Insurance";
		$obj->orgs = $num;
		$data[] = $obj;
	}
	

	// echo $string;

// 6 Governance
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Governance"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Security and public safety"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->sector = "Governance";
		$obj->orgs = $num;
		$data[] = $obj;
	}
	

	// echo $string;

// 7 Health
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Healthcare"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Water and sanitation"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Scientific research"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string3 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2 + $string3;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->sector = "Health";
		$obj->orgs = $num;
		$data[] = $obj;
	}
	

	// echo $string;

// 8 Housing construction and real estate
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Housing/real estate"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		if ( (int)$row["count(distinct(org_name))"] != 0 ) {
			$obj = new stdClass();
		$obj->sector = "Housing, Construction & Real Estate";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'East Asia & Pacific'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
		}
		
	}

	// echo $string;

	// 9 media and communications
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Media and communications"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Telecommunications/internet service providers"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->sector = "Media & Communications";
		$obj->orgs = $num;
		$data[] = $obj;
	}
	

	// echo $string;

	// 10 Housing construction and real estate
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Transportation and logistics"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		if ( (int)$row["count(distinct(org_name))"] != 0 ) {
			$obj = new stdClass();
		$obj->sector = "Transportation & Logistics";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'East Asia & Pacific'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
		}
		
	}

	// echo $string;

	// 11 media and communications
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Arts and culture"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string1 = $row["count(distinct(org_name))"];
	}

	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Tourism"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		$string2 = $row["count(distinct(org_name))"];
	}

	$num = $string1 + $string2;

	if ($num != 0) {
		$obj = new stdClass();
		$obj->sector = "Arts, Culture & Tourism";
		$obj->orgs = $num;
		$data[] = $obj;
	}
	

	// echo $string;

	// 12 consumer
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Consumer services"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		if ( (int)$row["count(distinct(org_name))"] != 0 ) {
			$obj = new stdClass();
		$obj->sector = "Consumer";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'East Asia & Pacific'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
		}
		
	}

	// echo $string;

	// 12 consumer
	$sql = 'SELECT count(distinct(org_name)) from org_profiles, org_locations, org_country_info
			where org_profiles.location_id = org_locations.location_id
			and org_locations.country_id = org_country_info.country_id
			and org_hq_country_region = "East Asia & Pacific"
			and industry_id = "Education"
			and org_profile_status = "publish";';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){
		// $string = $row["count(distinct(org_name))"];
		if ( (int)$row["count(distinct(org_name))"] ) {
			$obj = new stdClass();
		$obj->sector = "Education";
		$obj->orgs = (int)$row["count(distinct(org_name))"];
		$data[] = $obj;
		// var_dump($row);
		// $row->{'count(distinct(org_name))'} = $row->{'East Asia & Pacific'};
		// unset($row->{'count(distinct(org_name))'});
		// var_dump($row);
		}
		
	}

	// echo $string;

	echo json_encode($data);
?>