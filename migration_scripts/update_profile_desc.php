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
  echo org_desc_update($conn, $record);
}


function org_desc_update($conn, $record){
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
  
  $element["org_description"] = isset($record["org_description"])? htmlspecialchars($record["org_description"]) : null;
  $element["org_additional"] = isset($record["org_additional"])? htmlspecialchars($record["org_additional"]) : null;
  $element["org_greatest_impact_detail"] = isset($record["org_greatest_impact_detail"])? htmlspecialchars($record["org_greatest_impact_detail"]) : null;

  echo $element['profile_id'];
  echo "<br>";
  
  $query = "UPDATE org_profiles SET    
    org_description = \"" .$element["org_description"] . "\",
    org_additional = \"" .$element["org_additional"] . "\", 
    org_greatest_impact = \"" .$element["org_greatest_impact"] . "\" 
    WHERE profile_id=" . $element['profile_id'] . ";";

  $result = mysqli_query($conn, $query);

  if($result){
      echo "<br>...succeed";
      return;
  } else{
      echo "<br>";
      echo $query;
      print_r($conn);
      return ("<br>Failed on " . $record['org_name']);
  }

}

?>