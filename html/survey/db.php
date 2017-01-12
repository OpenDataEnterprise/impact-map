<?php
// connect to db
global $conn;
function connect(){
	$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	if (mysqli_connect_errno()) {
        echo "Error connecting to database: " . mysqli_connect_error();
    }
    return $conn;
}

// db handlers
class DBHandle{

	public $conn;
	function __construct(){
		$this->conn = connect();
	}

// Get a list of names and profile IDs for all organizations in the database (and every other information other than “data_use”)
	public function getorg_profiles(){
		$sql = "SELECT org_profiles.profile_id, industry_id, org_description, org_name, org_size, org_type, org_url, org_year_founded, advocacy, advocacy_desc, org_opt, org_opt_desc, use_other, use_other_desc, prod_srvc, prod_srvc_desc, research, research_desc, org_hq_country, org_hq_country_income, org_hq_country_region, org_hq_city, org_hq_st_prov, machine_read
		from org_profiles, data_applications, org_country_info, org_locations 
		where org_profiles.profile_id = data_applications.profile_id 
		and org_profiles.country_id = org_country_info.country_id 
		and org_profiles.location_id = org_locations.location_id
		and org_profiles.org_profile_status = 'publish';";
		$rs = $this->conn->query($sql);
		$all = $rs->fetch_all(MYSQLI_ASSOC);
		return $all;
	}

// Provide a full list of data uses (with profile_id attached to it).
	public function getdata_uses(){
		$sql = "SELECT org_data_use.profile_id, data_type, data_use_type_other, data_src_gov_level, org_country_info.org_hq_country
from org_data_use, org_profiles, org_country_info
where org_data_use.profile_id = org_profiles.profile_id
and org_country_info.country_id = org_data_use.src_country_id
and org_profiles.org_profile_status = 'publish';";
		$rs = $this->conn->query($sql);
		$all = $rs->fetch_all(MYSQLI_ASSOC);
		return $all;
	}

// Get complete profiles of all organizations in a region.
	public function getall_in_region($region){
		$sql = "SELECT org_profiles.profile_id, industry_id, org_description, org_name, org_size, org_type, org_url, org_year_founded, advocacy, advocacy_desc, org_opt, org_opt_desc, use_other, use_other_desc, prod_srvc, prod_srvc_desc, research, research_desc, org_hq_country, org_hq_country_income, org_hq_country_region, org_hq_city, org_hq_st_prov, machine_read
		from org_profiles, data_applications, org_country_info, org_locations 
		where org_profiles.profile_id = data_applications.profile_id 
		and org_profiles.country_id = org_country_info.country_id 
		and org_profiles.location_id = org_locations.location_id
		and org_country_info.org_hq_country_region = '$region'
		and org_profiles.org_profile_status = 'publish';";
		$rs = $this->conn->query($sql);
		$all = $rs->fetch_all(MYSQLI_ASSOC);
		return $all;
	}

// Get complete profiles of all organizations in a sector.
	public function getall_in_sector($sector){
		$sql = "SELECT org_profiles.profile_id, industry_id, org_description, org_name, org_size, org_type, org_url, org_year_founded, advocacy, advocacy_desc, org_opt, org_opt_desc, use_other, use_other_desc, prod_srvc, prod_srvc_desc, research, research_desc, org_hq_country, org_hq_country_income, org_hq_country_region, org_hq_city, org_hq_st_prov, machine_read
		from org_profiles, data_applications, org_country_info, org_locations 
		where org_profiles.profile_id = data_applications.profile_id 
		and org_profiles.country_id = org_country_info.country_id 
		and org_profiles.location_id = org_locations.location_id
		and org_profiles.industry_id = '$sector'
		and org_profiles.org_profile_status = 'publish';";
		$rs = $this->conn->query($sql);
		$all = $rs->fetch_all(MYSQLI_ASSOC);
		return $all;
	}
}