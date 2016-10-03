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

if (!file_exists('../survey/credentials.inc.php')) {
   echo "My credentials are missing!";
   exit;
}

// Include credentials
require '../survey/credentials.inc.php';
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$string = file_get_contents("flatfile/flatfile_new.json");
$profile_json = json_decode($string, true);

foreach ($profile_json['results'] as $record){
  echo org_location_update($conn, $record);
}
echo "<br>...succeed";


function org_location_update($conn, $record){
  if ($record["row_type"] != "org_profile") {
    return;
  }

  $element = array();

  // profile ID
  $sql = "SELECT profile_id FROM org_profiles WHERE parse_profile_id ='" .
        $record['profile_id'] . "'";
  $result = mysqli_query($conn, $sql);
  
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $element['profile_id'] = $row['profile_id'];    
  } else {
      echo "<br>  No Profile ID for this...";
  }  
  

  $element["advocacy"] = isset($record["use_advocacy"]) ? intval($record["use_advocacy"]) : null;
  $element["org_opt"] = isset($record["use_org_opt"]) ? intval($record["use_org_opt"]) : null;
  $element["use_other"] = isset($record["use_other"]) ? intval($record["use_other"]) : null;
  $element["prod_srvc"] = isset($record["use_prod_srvc"]) ? intval($record["use_prod_srvc"]) : null;
  $element["research"] = isset($record["use_research"]) ? intval($record["use_research"]) : null;

  $element["advocacy_desc"] = isset($record["use_advocacy_desc"])? mysql_real_escape_string($record["use_advocacy_desc"]) : null;
  $element["org_opt_desc"] = isset($record["use_org_opt_desc"])? mysql_real_escape_string($record["use_org_opt_desc"]) : null;
  $element["use_other_desc"] = isset($record["use_other_desc"])? mysql_real_escape_string($record["use_other_desc"]) : null;
  $element["prod_srvc_desc"] = isset($record["use_prod_srvc_desc"])? mysql_real_escape_string($record["use_prod_srvc_desc"]) : null;
  $element["research_desc"] = isset($record["use_research_desc"])? mysql_real_escape_string($record["use_research_desc"]) : null;

  $sql2 = "SELECT object_id FROM data_applications WHERE profile_id =" . $element['profile_id'] . ";";
  $result2 = mysqli_query($conn, $sql2);
  
  if ($result2->num_rows > 0) {
    $row = $result2->fetch_assoc();
    $object_id = $row['object_id'];     
  } else {
      echo "<br>  No Object ID for this...";
  }  

  
  $query = "UPDATE data_applications SET    
    advocacy = " . $element["advocacy"] . ", 
    org_opt = " . $element["org_opt"] . ",
    use_other = " .$element["use_other"]. ",
    prod_srvc = " .$element["prod_srvc"] . ",
    research = " .$element["research"] . ",
    advocacy_desc = '" .$element["advocacy_desc"] . "',
    org_opt_desc = '" .$element["org_opt_desc"] . "',
    use_other_desc = '" .$element["use_other_desc"] . "',
    prod_srvc_desc = '" .$element["prod_srvc_desc"] . "',
    research_desc = '" .$element["research_desc"] . "' 
    WHERE object_id=" . $object_id;

  $result = mysqli_query($conn, $query);

  if($result){
      return;
  } else{
      echo "<br>";
      echo $query;
      print_r($conn);
      return ("<br>Failed on " . $record['org_name']);
  }

}

?>