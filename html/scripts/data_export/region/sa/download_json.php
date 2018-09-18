<?php  
	$serverDate = date("Y_m_d");
	// tell browser (how) to download this file
	header('Content-type: application/json');
	header("Content-disposition: attachment; filename=Open Data Impact Map _ Data Export _ South Asia _ $serverDate.json");
	

	// ini_set('memory_limit', '256M'); // or you could use 1G

	include_once("../../../../survey/credentials.inc.php");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

// initiate the object, put in some data to objects to an array

	class orgProfile {
		public $Region;
		public $Country;
		public $Country_income_level;
		public $Organization_name;
		public $Type_of_organization;
		public $Organization_description;
		public $Sector;
		public $URL;
		public $City;
		public $State_County;
		public $Founding_year;
		public $Size;
		public $Type_of_data_used;
		public $Application_Advocacy;
		public $Advocacy_description;
		public $Application_Product_Service;
		public $Product_Service_Description;
		public $Application_Organizational_Optimization;
		public $Organizational_Optimization_Description;
		public $Application_Research;
		public $Research_Description;
		public $Application_Other;
		public $Other_Description;
	}

	$sql = "SELECT industry_id, org_description, org_name, org_size, org_type, org_url, org_year_founded, advocacy, advocacy_desc, org_opt, org_opt_desc, use_other, use_other_desc, prod_srvc, prod_srvc_desc, research, research_desc, org_hq_country, org_hq_country_income, org_hq_country_region, org_hq_city, org_hq_st_prov 
		from org_profiles, data_applications, org_country_info, org_locations 
		where org_profiles.profile_id = data_applications.profile_id 
		and org_profiles.country_id = org_country_info.country_id 
		and org_profiles.location_id = org_locations.location_id 
		and org_hq_country_region = 'South Asia';";


	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	// an index for counting in while loop
	$i=0;
	while($row = $result->fetch_assoc()){
		// var_dump($row["org_name"]);
		$profiles[] = new orgProfile();
		$profiles[$i]->Sector = $row["industry_id"];
		$profiles[$i]->Organization_description = $row["org_description"];
		$profiles[$i]->Organization_name = $row["org_name"];
		$pattern = '/-/';
		$replacement = ' to ';
		$profiles[$i]->Size = preg_replace($pattern, $replacement, $row["org_size"]);
		$profiles[$i]->Type_of_organization = $row["org_type"];
		$profiles[$i]->URL = $row["org_url"];
		$profiles[$i]->Founding_year = $row["org_year_founded"];
		// convert 1 and 0 to true false string for better presentation for CSV users
		// app 1
		if ($row["advocacy"] == 0) {
			$profiles[$i]->Application_Advocacy = "FALSE";
		} else {
			$profiles[$i]->Application_Advocacy = "TRUE";
		}
		$profiles[$i]->Advocacy_description = $row["advocacy_desc"];
		// app 2
		if ($row["org_opt"] == 0) {
			$profiles[$i]->Application_Organizational_Optimization = "FALSE";
		} else {
			$profiles[$i]->Application_Organizational_Optimization = "TRUE";
		}
		$profiles[$i]->Organizational_Optimization_Description = $row["org_opt_desc"];
		// app 3
		if ($row["use_other"] == 0) {
			$profiles[$i]->Application_Other = "FALSE";
		} else {
			$profiles[$i]->Application_Other = "TRUE";
		}
		$profiles[$i]->Other_Description = $row["use_other_desc"];
		// app 4
		if ($row["prod_srvc"] == 0) {
			$profiles[$i]->Application_Product_Service = "FALSE";
		} else {
			$profiles[$i]->Application_Product_Service = "TRUE";
		}
		$profiles[$i]->Product_Service_Description = $row["prod_srvc_desc"];
		// app5
		if ($row["research"] == 0) {
			$profiles[$i]->Application_Research = "FALSE";
		} else {
			$profiles[$i]->Application_Research = "TRUE";
		}
		$profiles[$i]->Research_Description = $row["research_desc"];
		// all apps finished converting
		$profiles[$i]->Country = $row["org_hq_country"];
		$profiles[$i]->Country_income_level = $row["org_hq_country_income"];
		$profiles[$i]->Region = $row["org_hq_country_region"];
		$profiles[$i]->City = $row["org_hq_city"];
		$profiles[$i]->State_County = $row["org_hq_st_prov"];
		
		// echo $i;
		// var_dump($profiles[$i]);
		$i++;
	}

	// insert data type data
	$sql = "SELECT org_name, data_type 
		from org_profiles, org_data_use 
		where org_data_use.profile_id = org_profiles.profile_id;";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	while($row = $result->fetch_assoc()){

		foreach ($profiles as $profile) {
			if ($profile->Organization_name == $row["org_name"]) {
				if ($profile->Type_of_data_used) {
					if ( strstr($row["data_type"], $profile->Type_of_data_used) == FALSE ) {
						if ($row["data_type"] != "") {
							$profile->Type_of_data_used = $profile->Type_of_data_used . ", " . $row["data_type"];
						}
					}
				} else {
					$profile->Type_of_data_used = $profile->Type_of_data_used . $row["data_type"];
				}	
			}
		}
	
	}

	// var_dump($profiles);
	echo json_encode($profiles, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

// end of code
?>
