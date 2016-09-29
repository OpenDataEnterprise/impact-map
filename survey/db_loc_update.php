<?php
// Expand memory being used by PHP
ini_set('memory_limit','400M');
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(3600);
session_start();
$now = time();
// echo "discard after: $now<br>";
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}
// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 3600;
// echo "<pre>top of script\n"; print_r($_SESSION);

// Configuration

date_default_timezone_set('America/New_York'); 

if (!file_exists('credentials.inc.php')) {
   echo "My credentials are missing!";
   exit;
}

// Include libraries added with composer
require 'vendor/autoload.php';
// Include credentials
require 'credentials.inc.php';
// Include parse library
require ('vendor/parse.com-php-library/parse.php');
// Include application functions
require 'functions.inc.php';

// update_db("org_hq_country", "blank", 0);
// update_db("org_hq_country", "undefined", 0);
// update_db("org_hq_country_region_code", "blank", 0);
// update_db("org_hq_country_region_code", "undefined", 0);
// update_db("org_hq_country_region", "blank", 0);
// update_db("org_hq_country_region", "undefined", 0);
// update_db("org_hq_country_income_code", "blank", 0);
// update_db("org_hq_country_income_code", "undefined", 0);
// update_db("org_hq_country_income", "blank", 0);
// update_db("org_hq_country_income", "undefined", 0);
// update_db("org_hq_country_locode", "defined", 0);
// update_db("org_hq_country_locode", "defined", 1);
// update_db("org_hq_country_locode", "defined", 2);
// update_db("org_hq_country_locode", "defined", 3);

// flatfile_update_db("org_hq_country", "blank", 0);
// flatfile_update_db("org_hq_country", "undefined", 0);
// flatfile_update_db("org_hq_country_region_code", "blank", 0);
// flatfile_update_db("org_hq_country_region_code", "undefined", 0);
// flatfile_update_db("org_hq_country_region", "blank", 0);
// flatfile_update_db("org_hq_country_region", "undefined", 0);
// flatfile_update_db("org_hq_country_income_code", "blank", 0);
// flatfile_update_db("org_hq_country_income_code", "undefined", 0);
//flatfile_update_db("org_hq_country_income", "blank", 0);
// flatfile_update_db("org_hq_country_income", "undefined", 0);
// flatfile_update_db("org_hq_country_locode", "defined", 0);
// flatfile_update_db("org_hq_country_locode", "defined", 1);
// flatfile_update_db("org_hq_country_locode", "defined", 2);
// flatfile_update_db("org_hq_country_locode", "defined", 3);
// flatfile_update_db("org_hq_country_locode", "defined", 4);
// flatfile_update_db("org_hq_country_locode", "defined", 5);
// flatfile_update_db("org_hq_country_locode", "defined", 6);
// flatfile_update_db("org_hq_country_locode", "defined", 7);

/* 5/17/2016. use_... fields updates, by Myeong */
$profile_ids = array();
$file = fopen("data/ode_to_update2.csv","r");

$i = 0;

while(!feof($file))
{
  $profile_ids[$i] = fgetcsv($file);
  if ($profile_ids[0] == "Profile ID") continue;
  $i += 1;
}

fclose($file);    
$i = 0;

foreach ($profile_ids as $record){
  print ("Profile ID: " . strval($record[0]) . " -- ");
  
  print (org_profile_update($record));
  print (flatfile_update($record));
  print ("<br>");
}
// flatfile_update_db("org_hq_country_locode", "defined", 7);

/* For "org_profile" table, use_... fields */
function org_profile_update($record){

  $query = new ParseQuery("org_profile");
  $query->whereEqualTo("profile_id", $record[0]);
  $query->setLimit(100);
  $results = $query->find();

  $element = array();
  $data_use_type =array();
  $i=0;

  foreach ($results as $object){
    if (empty($object)){
        return "Not exist";
    } else {

      foreach($object as $obj){
          
          $element[$obj->objectId]["use_advocacy"] = filter_var($record[1], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_advocacy_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[2]);
          $element[$obj->objectId]["use_prod_srvc"] = filter_var($record[3], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_prod_srvc_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[4]);
          $element[$obj->objectId]["use_org_opt"] = filter_var($record[5], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_org_opt_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[6]);
          $element[$obj->objectId]["use_research"] = filter_var($record[7], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_research_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[8]);
          $element[$obj->objectId]["use_other"] = filter_var($record[9], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_other_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[10]);

          $data_use_type = $obj->data_use_type;
          if ($obj->industry_id == "Agriculture") {
            if (!in_array("Agriculture", $obj->data_use_type)) {
              array_push($data_use_type, "Agriculture");
            }
          }
          if ($obj->industry_id == "Geospatial/mapping") {
            if (!in_array("Geospatial/mapping", $obj->data_use_type)) {
              array_push($data_use_type, "Geospatial/mapping");
            }
          }
          if ($obj->industry_id == "Weather") {
            if (!in_array("Weather", $obj->data_use_type)) {
              array_push($data_use_type, "Weather");
            }
          }
          $element[$obj->objectId]["data_use_type"] = $data_use_type;

      }
    }
  }

  // updating the server
  foreach ($element as $key=>$value){
    $parse = new ParseObject('org_profile');
    $parse->__set('objectId', $key);    
    $parse->__set('use_advocacy', $value["use_advocacy"]);
    $parse->__set('use_advocacy_desc', $value["use_advocacy_desc"]);
    $parse->__set('use_prod_srvc', $value["use_prod_srvc"]);
    $parse->__set('use_prod_srvc_desc', $value["use_prod_srvc_desc"]);
    $parse->__set('use_org_opt', $value["use_org_opt"]);
    $parse->__set('use_org_opt_desc', $value["use_org_opt_desc"]);
    $parse->__set('use_research', $value["use_research"]);
    $parse->__set('use_research_desc', $value["use_research_desc"]);
    $parse->__set('use_other', $value["use_other"]);
    $parse->__set('use_other_desc', $value["use_other_desc"]);
    $parse->__set('data_use_type', $value["data_use_type"]);
    $request = $parse->update($key);
    
    usleep(200);
  }
  return "org_profile Success. ";
}

function flatfile_update($record){

  $query = new ParseQuery("arcgis_flatfile");
  $query->whereEqualTo("profile_id", $record[0]);
  $query->setLimit(100);
  $results = $query->find();

  $element = array(); // for updating
  $new_element = array(); // for new entry for data_type
  $i=0;
  $data_add_flag = false;

  foreach ($results as $object){
    if (empty($object)){
        return "Not exist";
    } else {   
      foreach($object as $obj){

          $data_use_type =array();
          $element[$obj->objectId]["use_advocacy"] = filter_var($record[1], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_advocacy_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[2]);
          $element[$obj->objectId]["use_prod_srvc"] = filter_var($record[3], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_prod_srvc_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[4]);
          $element[$obj->objectId]["use_org_opt"] = filter_var($record[5], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_org_opt_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[6]);
          $element[$obj->objectId]["use_research"] = filter_var($record[7], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_research_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[8]);
          $element[$obj->objectId]["use_other"] = filter_var($record[9], FILTER_VALIDATE_BOOLEAN);
          $element[$obj->objectId]["use_other_desc"] = str_replace(array("\r\n", "\r", "\n"), "", $record[10]);

          $data_use_type = $obj->data_use_type;
          $new_data_type = ""; 
          if ($obj->industry_id == "Agriculture") {
            if (!in_array("Agriculture", $obj->data_use_type)) {
              array_push($data_use_type, "Agriculture");
              $data_add_flag = true;
              $new_data_type = "Agriculture";
            }
          }
          if ($obj->industry_id == "Geospatial/mapping") {
            if (!in_array("Geospatial/mapping", $obj->data_use_type)) {
              array_push($data_use_type, "Geospatial/mapping");
              $data_add_flag = true;
              $new_data_type = "Geospatial/mapping";
            }
          }
          if ($obj->industry_id == "Weather") {
            if (!in_array("Weather", $obj->data_use_type)) {
              array_push($data_use_type, "Weather");
              $data_add_flag = true;
              $new_data_type = "Weather";
            }
          }
          $element[$obj->objectId]["data_use_type"] = $data_use_type;

          // Copyting information for a new entry
          if (empty($new_element) && $data_add_flag == true){
            $new_element['profile_id'] = $obj->profile_id;
            $new_element['use_advocacy'] = filter_var($record[1], FILTER_VALIDATE_BOOLEAN);
            $new_element['use_advocacy_desc'] = str_replace(array("\r\n", "\r", "\n"), "", $record[2]);
            $new_element['use_prod_srvc'] = filter_var($record[3], FILTER_VALIDATE_BOOLEAN);
            $new_element['use_prod_srvc_desc'] = str_replace(array("\r\n", "\r", "\n"), "", $record[4]);
            $new_element['use_org_opt'] = filter_var($record[5], FILTER_VALIDATE_BOOLEAN);
            $new_element['use_org_opt_desc'] = str_replace(array("\r\n", "\r", "\n"), "", $record[6]);
            $new_element['use_research'] = filter_var($record[7], FILTER_VALIDATE_BOOLEAN);
            $new_element['use_research_desc'] = str_replace(array("\r\n", "\r", "\n"), "", $record[8]);
            $new_element['use_other'] = filter_var($record[9], FILTER_VALIDATE_BOOLEAN);
            $new_element['use_other_desc'] = str_replace(array("\r\n", "\r", "\n"), "", $record[10]);
            $new_element['data_use_type'] = $data_use_type;
            $new_element['org_description'] = $obj->org_description;
            $new_element['org_additional'] = $obj->org_additional;
            $new_element['org_profile_status'] = $obj->org_profile_status;
            $new_element['data_src_country_name'] = $obj->data_src_country_name;
            $new_element['org_hq_city'] = $obj->org_hq_city;
            $new_element['org_type_other'] = $obj->org_type_other;
            $new_element['org_name'] = $obj->org_name;
            $new_element['data_src_country_locode'] = $obj->data_src_country_locode;
            $new_element['latitude'] = $obj->latitude;
            $new_element['org_hq_st_prov'] = $obj->org_hq_st_prov;
            $new_element['org_hq_country_income'] = $obj->org_hq_country_income;
            $new_element['org_hq_country_income_code'] = $obj->org_hq_country_income_code;
            $new_element['org_profile_year'] = $obj->org_profile_year;
            $new_element['longitude'] = $obj->longitude;
            $new_element['data_type'] = $new_data_type;
            $new_element['org_profile_category'] = $obj->org_profile_category;
            $new_element['org_greatest_impact'] = $obj->org_greatest_impact;
            $new_element['org_greatest_impact_detail'] = $obj->org_greatest_impact_detail;
            // $new_element['data_country_count'] = $obj->data_country_count;
            $new_element['org_profile_src'] = $obj->org_profile_src;
            $new_element['org_hq_country_locode'] = $obj->org_hq_country_locode;
            $new_element['org_hq_country_region'] = $obj->org_hq_country_region;
            $wb_region = addWbRegions($obj->org_hq_country_locode);
            $new_element['org_hq_country_region_code'] = $wb_region['org_hq_country_region_code'];
            $new_element['org_url'] = $obj->org_url;
            $new_element['org_type'] = $obj->org_type;
            $new_element['no_org_url'] = $obj->no_org_url;
            $new_element['org_year_founded'] = $obj->org_year_founded;
            $new_element['org_hq_country'] = $obj->org_hq_country;
            $new_element['industry_id'] = $obj->industry_id;
            $new_element['row_type'] = "data_use";
            $new_element['org_size_id'] = $obj->org_size_id;
          }
      }

    }
  }

  // updating the server
  foreach ($element as $key=>$value){
    $parse = new ParseObject('arcgis_flatfile');
    $parse->__set('objectId', $key);    
    $parse->__set('use_advocacy', $value["use_advocacy"]);
    $parse->__set('use_advocacy_desc', $value["use_advocacy_desc"]);
    $parse->__set('use_prod_srvc', $value["use_prod_srvc"]);
    $parse->__set('use_prod_srvc_desc', $value["use_prod_srvc_desc"]);
    $parse->__set('use_org_opt', $value["use_org_opt"]);
    $parse->__set('use_org_opt_desc', $value["use_org_opt_desc"]);
    $parse->__set('use_research', $value["use_research"]);
    $parse->__set('use_research_desc', $value["use_research_desc"]);
    $parse->__set('use_other', $value["use_other"]);
    $parse->__set('use_other_desc', $value["use_other_desc"]);
    $parse->__set('data_use_type', $value["data_use_type"]);
    $request = $parse->update($key);
    
    usleep(200);
  }
  if ($data_add_flag == true){
    $parse2 = new ParseObject('arcgis_flatfile');
    $parse2->__set('use_advocacy', $new_element["use_advocacy"]);
    $parse2->__set('use_advocacy_desc', $new_element["use_advocacy_desc"]);
    $parse2->__set('use_prod_srvc', $new_element["use_prod_srvc"]);
    $parse2->__set('use_prod_srvc_desc', $new_element["use_prod_srvc_desc"]);
    $parse2->__set('use_org_opt', $new_element["use_org_opt"]);
    $parse2->__set('use_org_opt_desc', $new_element["use_org_opt_desc"]);
    $parse2->__set('use_research', $new_element["use_research"]);
    $parse2->__set('use_research_desc', $new_element["use_research_desc"]);
    $parse2->__set('use_other', $new_element["use_other"]);
    $parse2->__set('use_other_desc', $new_element["use_other_desc"]);
    $parse2->__set('data_use_type', $new_element["data_use_type"]);
    $parse2->__set('profile_id', $new_element['profile_id']);
    $parse2->__set('org_description', $new_element['org_description']);
    $parse2->__set('org_additional', $new_element['org_additional']);
    $parse2->__set('org_profile_status', $new_element['org_profile_status']);
    $parse2->__set('data_src_country_name', $new_element['data_src_country_name']);
    $parse2->__set('org_hq_city', $new_element['org_hq_city']);
    $parse2->__set('org_type_other', $new_element['org_type_other']);
    $parse2->__set('org_name', $new_element['org_name']);
    $parse2->__set('data_src_country_locode', $new_element['data_src_country_locode']);
    $parse2->__set('latitude', $new_element['latitude']);
    $parse2->__set('org_hq_st_prov', $new_element['org_hq_st_prov']);
    $parse2->__set('org_hq_country_income', $new_element['org_hq_country_income']);
    $parse2->__set('org_hq_country_income_code', $new_element['org_hq_country_income_code']);
    $parse2->__set('org_profile_year', $new_element['org_profile_year']);
    // $parse2->__set('industry_other', $new_element['industry_other']);
    $parse2->__set('longitude', $new_element['longitude']);
    $parse2->__set('data_type', $new_element['data_type']);
    $parse2->__set('org_profile_category', $new_element['org_profile_category']);
    $parse2->__set('org_greatest_impact', $new_element['org_greatest_impact']);
    $parse2->__set('org_greatest_impact_detail', $new_element['org_greatest_impact_detail']);
    // $parse2->__set('data_country_count', $new_element['data_country_count']);
    $parse2->__set('org_profile_src', $new_element['org_profile_src']);
    $parse2->__set('org_hq_country_locode', $new_element['org_hq_country_locode']);
    $parse2->__set('org_hq_country_region', $new_element['org_hq_country_region']);
    $parse2->__set('org_hq_country_region_code', $new_element['org_hq_country_region_code']);
    $parse2->__set('org_url', $new_element['org_url']);
    $parse2->__set('org_type', $new_element['org_type']);
    $parse2->__set('no_org_url', $new_element['no_org_url']);
    $parse2->__set('org_year_founded', $new_element['org_year_founded']);
    $parse2->__set('org_hq_country', $new_element['org_hq_country']);
    $parse2->__set('industry_id', $new_element['industry_id']);
    $parse2->__set('row_type', $new_element['row_type']);
    $parse2->__set('org_size_id', $new_element['org_size_id']);
    $request2 = $parse2->save();
    usleep(200);
    print ("a new data type added. ");
  }
  return "Flatfile Success.";
}





function flatfile_update_db($missing_column, $condition, $loop){

  $query = new ParseQuery("arcgis_flatfile");
  $query->setLimit(500);
  $query->setSkip($loop * 500);

 
  if ($condition == "undefined"){
    echo $missing_column . " for undefined." . "<br>";
    $query->whereEqualTo($missing_column, "");
  } elseif ($condition == "blank") {
    echo $missing_column . " for not exist." . "<br>";
    $query->whereDoesNotExist($missing_column);
  } elseif ($condition == "defined") {
    echo $missing_column . " for defined." . "<br>";
    $query->whereExists($missing_column);
  }

  $results = $query->find();

  $need_update = FALSE;
  $element = array();
  $i=0;

  foreach ($results as $object){
    foreach($object as $obj){   
      $wb_region = addWbRegions($obj->org_hq_country_locode);
      
      if (!isset($obj->org_hq_country_locode) or $obj->org_hq_country_locode=="") continue;      

      if (!isset($obj->org_hq_country_region_code) or
        !isset($obj->org_hq_country_region) ) {
        $element[$obj->objectId] = array(        
          "org_hq_country_locode" => $obj->org_hq_country_locode,
        );
        // $element[$obj->objectId]["org_hq_country"] = $wb_region['org_hq_country_name'];          
        $element[$obj->objectId]["org_hq_country_region"] = $wb_region['org_hq_country_region'];                   
        $element[$obj->objectId]["org_hq_country_region_code"] = $wb_region['org_hq_country_region_code'];          
        // $element[$obj->objectId]["org_hq_country_income"] = $wb_region['org_hq_country_income'];               
        // $element[$obj->objectId]["org_hq_country_income_code"] = $wb_region['org_hq_country_income_code'];   
        $need_update = TRUE;             
      }

      if ($need_update){
        echo $obj->objectId;    
        echo '<br>';
      }
      $i++;
      if ($i == 500) break;
    }
    print("hello");
  }
  echo '<br>';

  if (sizeof($element)==0){
    echo "No data to update <br>";    
  }

  if ($need_update){
    $count = 0;

    foreach ($element as $key=>$value){

      $parse = new ParseObject('arcgis_flatfile');
      $parse->__set('objectId', $key);
      // $parse->__set('org_hq_country', $value["org_hq_country"]);
      // $parse->__set('org_hq_country_locode', $value["org_hq_country_locode"]);
      $parse->__set('org_hq_country_region', $value["org_hq_country_region"]);
      $parse->__set('org_hq_country_region_code', $value["org_hq_country_region_code"]);
      // $parse->__set('org_hq_country_income', $value["org_hq_country_income"]);
      // $parse->__set('org_hq_country_income_code', $value["org_hq_country_income_code"]);
      $request = $parse->update($key);
      $count++;
      usleep(500);
    }


    echo $missing_column . ": " . strval($count) . " completed<br>";
    echo '<br>';
  }
}

/* For "org_profile" table */
function update_db($missing_column, $condition, $loop){

  $query = new ParseQuery("org_profile");
  $query->setLimit(500);
  $query->setSkip($loop * 500);

 
  if ($condition == "undefined"){
    echo $missing_column . " for undefined." . "<br>";
    $query->whereEqualTo($missing_column, "");
  } elseif ($condition == "blank") {
    echo $missing_column . " for undefined." . "<br>";
    $query->whereDoesNotExist($missing_column);
  } elseif ($condition == "defined") {
    echo $missing_column . " for defined." . "<br>";
    $query->whereExists($missing_column);
  }

  $results = $query->find();

  $need_update = FALSE;
  $element = array();
  $i=0;

  foreach ($results as $object){
    foreach($object as $obj){  	
      $wb_region = addWbRegions($obj->org_hq_country_locode);
      
      if (!isset($obj->org_hq_country_locode) or $obj->org_hq_country_locode=="") continue;

      // if (!isset($obj->org_hq_country) && !isset($obj->org_hq_country_region) && !isset($obj->org_hq_country_region_code) &&
      //   !isset($obj->org_hq_country_income) && !isset($obj->org_hq_country_income_code)) {
      if (!isset($obj->org_hq_country_region_code) &&
        !isset($obj->org_hq_country_income) && !isset($obj->org_hq_country_income_code)) {
        $element[$obj->objectId] = array(        
          "org_hq_country_locode" => $obj->org_hq_country_locode,
        );
        // $element[$obj->objectId]["org_hq_country"] = $wb_region['org_hq_country_name'];          
        // $element[$obj->objectId]["org_hq_country_region"] = $wb_region['org_hq_country_region'];                   
        $element[$obj->objectId]["org_hq_country_region_code"] = $wb_region['org_hq_country_region_code'];          
        $element[$obj->objectId]["org_hq_country_income"] = $wb_region['org_hq_country_income'];               
        $element[$obj->objectId]["org_hq_country_income_code"] = $wb_region['org_hq_country_income_code'];   
        $need_update = TRUE;       
      }

      if ($need_update){
        echo $obj->objectId;    
        echo '<br>';
      }
      $i++;
      if ($i == 500) break;
    }
    
  }
  echo '<br>';

  if (sizeof($element)==0){
    echo "No data to update <br>";    
  }

  if ($need_update){
    $count = 0;

    foreach ($element as $key=>$value){

      $parse = new ParseObject('org_profile');
      $parse->__set('objectId', $key);
      // $parse->__set('org_hq_country', $value["org_hq_country"]);
      // $parse->__set('org_hq_country_locode', $value["org_hq_country_locode"]);
      // $parse->__set('org_hq_country_region', $value["org_hq_country_region"]);
      $parse->__set('org_hq_country_region_code', $value["org_hq_country_region_code"]);
      $parse->__set('org_hq_country_income', $value["org_hq_country_income"]);
      $parse->__set('org_hq_country_income_code', $value["org_hq_country_income_code"]);
      $request = $parse->update($key);
      $count++;
      usleep(500);
    }


    echo $missing_column . ": " . strval($count) . " completed<br>";
    echo '<br>';
  }
}



?>