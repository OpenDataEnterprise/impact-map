<?php
// define db connection constants
	//Noah local
define("DB_HOST", "localhost:8889");
define("DB_USER", "root");
define("DB_PWD", "19880518");
define("DB_NAME", "ode_survey");
	//server
// define("DBHOST", "localhost");
// define("DBNAME", "ode_survey");
// define("DBUSER", "root");
// define("DBPASS", "Sep@2016");

// connect to db
global $conn;
function connect(){
	$conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);
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

// // get a list of all orgs and their profile id
// 	public function getOrgList(){
// 		$sql = "SELECT DISTINCT profile_id, org_name FROM org_profiles WHERE org_profile_status = 'publish';";
// 		$rs = $this->conn->query($sql);
// 		$orgs = $rs->fetch_all(MYSQLI_ASSOC);
// 		return $orgs;
// 	}

// // get the profile of one org
// 	public function getOrg($id){

// 		$sql = "SELECT DISTINCT * 
// from org_profiles, data_applications, org_country_info, org_locations, org_contacts, org_data_use
// where org_profiles.profile_id = data_applications.profile_id 
// and org_profiles.country_id = org_country_info.country_id 
// and org_profiles.location_id = org_locations.location_id 
// and org_profiles.profile_id = org_contacts.profile_id
// and org_profiles.profile_id = org_data_use.profile_id
// and org_profiles.profile_id = $id
// and org_profiles.org_profile_status = 'publish';";

// 		$rs = $this->conn->query($sql);
// 		$org = $rs->fetch_all(MYSQLI_ASSOC);
// 		return $org;
// 	}

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

// // get total number of orgs in the db
// 	public function getTotalNumberOfOrgs(){
// 		$sql = "SELECT count(distinct(org_name)) from org_profiles where org_profile_status = 'publish';";
// 		$rs = $this->conn->query($sql);
// 		$num = $rs->fetch_all(MYSQLI_ASSOC);
// 		return $num;
// 	}

// // get total number of countries in the db
// 	public function getTotalNumberOfCountries(){
// 		$sql = "SELECT count(distinct(country_id)) from org_profiles where org_profile_status = 'publish';";
// 		$rs = $this->conn->query($sql);
// 		$num = $rs->fetch_all(MYSQLI_ASSOC);
// 		return $num;
// 	}

// // get number of orgs in a region
// 	public function getNumberOfOrgsInRegion($region){
// 		$sql = "SELECT count(distinct(org_name))
// 		from org_profiles, org_locations, org_country_info
// 		where org_profiles.location_id = org_locations.location_id
// 		and org_locations.country_id = org_country_info.country_id
// 		and org_country_info.org_hq_country_region = '$region'
// 		and org_profiles.org_profile_status = 'publish';";
// 		$rs = $this->conn->query($sql);
// 		$num = $rs->fetch_all(MYSQLI_ASSOC);
// 		return $num;
// 	}

// // get number of orgs in a sector
// 	public function getNumberOfOrgsInSector($sector){
// 		$sql = "SELECT count(distinct(org_name))
// 			from org_profiles
// 			where org_profile_status = 'publish'
// 			and industry_id = '$sector';";
// 		$rs = $this->conn->query($sql);
// 		$num = $rs->fetch_all(MYSQLI_ASSOC);
// 		return $num;
// 	}



}



// $db = new DBHandle();
// $res = $db->getNumberOfOrgsInRegion('North America');
// // $res = $db->getOrg(2);
// var_dump($res);
