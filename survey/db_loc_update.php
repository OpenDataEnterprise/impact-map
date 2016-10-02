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

require 'credentials.inc.php';

require 'functions.inc.php';

// org_profile_update();
// data_use_update();
// org_name_update();
// size_update();
// sector_update();
country_code_update();


function country_code_update(){
  $vquery = "SELECT country_id, ISO2 FROM org_country_info";

  try {
    $conn = connect_db();
    $stmt = $conn->query($vquery);
    $rows = $stmt->fetchAll();        
  } 
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }    

  foreach ($rows as $row){
    echo $row["country_id"] . " ";
    echo $row["ISO2"];
    echo "<br>";

    $ISO2 = $row["ISO2"];    
    $pid = $row["country_id"];

    $ISO2 = trim($ISO2);   

    $update_query = "UPDATE org_country_info SET ISO2 = :ISO2 WHERE country_id=:country_id";

    try{
      $stmt2 = $conn->prepare($update_query);
      $stmt2->bindParam("country_id", $pid);
      $stmt2->bindParam("ISO2", $ISO2);
      $stmt2->execute();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
        print_r($update_query);
    }   

  }

  return "<br>....Success.<br>";
}

function sector_update() {
  $vquery = "SELECT profile_id, industry_id FROM org_profiles";

  try {
    $conn = connect_db();
    $stmt = $conn->query($vquery);
    $rows = $stmt->fetchAll();        
  } 
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }    

  foreach ($rows as $row){
    echo $row["profile_id"] . " ";
    echo $row["industry_id"];
    echo "<br>";

    $sector = $row["industry_id"];
    $pid = $row["profile_id"];

    if ($row["industry_id"] == "Business and legal services" || $row["industry_id"] == "Mining/manufacturing" 
      || $row["industry_id"] == "Research and consulting" || $row["industry_id"] == "Scientific research") {
      $sector = "Business, research and consulting";    
      $update_query = "UPDATE org_profiles SET industry_id = :sector WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("sector", $sector);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    } 
    else if ($row["industry_id"] == "Consumer services") {
      $sector = "Consumer";      
      $update_query = "UPDATE org_profiles SET industry_id = :sector WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("sector", $sector);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    }
    else if ($row["industry_id"] == "Data/information technology" || $row["industry_id"] == "Geospatial/mapping" 
      || $row["industry_id"] == "Telecommunications/internet service providers") {
      $sector = "IT and geospatial";      
      $update_query = "UPDATE org_profiles SET industry_id = :sector WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("sector", $sector);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    }
    else if ($row["industry_id"] == "Energy" || $row["industry_id"] == "Environment" 
      || $row["industry_id"] == "Water and sanitation" || $row["industry_id"] == "Weather") {
      $sector = "Energy and climate";      
      $update_query = "UPDATE org_profiles SET industry_id = :sector WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("sector", $sector);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    }
    else if ($row["industry_id"] == "Security and public safety") {
      $sector = "Governance";      
      $update_query = "UPDATE org_profiles SET industry_id = :sector WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("sector", $sector);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    }
    else if ($row["industry_id"] == "Tourism" || $row["industry_id"] == "Arts and culture") {
      $sector = "Arts, culture and tourism";      
      $update_query = "UPDATE org_profiles SET industry_id = :sector WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("sector", $sector);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    }
  }

  return "<br>....Success.<br>";
}

function size_update(){
  $vquery = "SELECT profile_id, org_size FROM org_profiles";

  try {
    $conn = connect_db();
    $stmt = $conn->query($vquery);
    $rows = $stmt->fetchAll();        
  } 
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }    

  foreach ($rows as $row){
    echo $row["profile_id"] . " ";
    echo $row["org_size"];
    echo "<br>";

    $org_size = $row["org_size"];    
    $pid = $row["profile_id"];

    if ($row["org_size"] == "1-10") $org_size = "1 to 10";
    else if ($row["org_size"] == "11-50") $org_size = "11 to 50";
    else if ($row["org_size"] == "51-200") $org_size = "51 to 200";
    else if ($row["org_size"] == "201-1000") $org_size = "201 to 1000";    

    $update_query = "UPDATE org_profiles SET org_size = :org_size WHERE profile_id=:profile_id";

    try{
      $stmt2 = $conn->prepare($update_query);
      $stmt2->bindParam("profile_id", $pid);
      $stmt2->bindParam("org_size", $org_size);
      $stmt2->execute();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
        print_r($update_query);
    }   

  }

  return "<br>....Success.<br>";
}

function org_name_update(){
  $vquery = "SELECT profile_id, org_name, org_type FROM org_profiles";

  try {
    $conn = connect_db();
    $stmt = $conn->query($vquery);
    $rows = $stmt->fetchAll();        
  } 
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }    

  foreach ($rows as $row){
    // echo $row["profile_id"] . " ";
    // echo $row["org_name"];
    // echo "<br>";

    $org_name = $row["org_name"];
    $org_type = $row["org_type"];
    $pid = $row["profile_id"];

    if (strpos($row["org_name"], "University") != false || strpos($row["org_name"], "university") != false){
      echo $row["profile_id"] . " ";
      echo $org_name. " ";
      echo $org_type;
      echo "<br>";

      $org_type = "Academic institution";
      $update_query = "UPDATE org_profiles SET org_type = :org_type WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("org_type", $org_type);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }   
    }
  }

  return "<br>....Success.<br>";
}


function data_use_update(){
  $vquery = "SELECT object_id, profile_id, data_type FROM org_data_use";

  try {
    $conn = connect_db();
    $stmt = $conn->query($vquery);
    $rows = $stmt->fetchAll();        
  } 
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }    

  foreach ($rows as $row){
    echo $row["object_id"] . " ";
    echo $row["data_type"];
    echo "<br>";
    
    $pid = $row["profile_id"];
    $oid = $row["object_id"];

    if ($row["data_type"] == "Demographics and social"){
      $data_type = "Demographic and social";    
      $update_query = "UPDATE org_data_use SET data_type = :data_type WHERE object_id=:object_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("object_id", $oid);
        $stmt2->bindParam("data_type", $data_type);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    } 
    else if ($row["data_type"] == "" || !isset($row["data_type"])) {
      $data_type = "Other";      
      $update_query = "UPDATE org_data_use SET data_type = :data_type WHERE object_id=:object_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("object_id", $oid);
        $stmt2->bindParam("data_type", $data_type);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    } else if ($row["data_type"] == "International/global development") {
      $data_type = "International development";      
      $update_query = "UPDATE org_data_use SET data_type = :data_type WHERE object_id=:object_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("object_id", $oid);
        $stmt2->bindParam("data_type", $data_type);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    } else if ($row["data_type"] == "Geospatial/mapping") {
      $data_type = "Geospatial";      
      $update_query = "UPDATE org_data_use SET data_type = :data_type WHERE object_id=:object_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("object_id", $oid);
        $stmt2->bindParam("data_type", $data_type);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    } else if ($row["data_type"] == "Manufacturing" || $row["data_type"] == "Economics" ) {
      $data_type = "Economic";      
      $update_query = "UPDATE org_data_use SET data_type = :data_type WHERE object_id=:object_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("object_id", $oid);
        $stmt2->bindParam("data_type", $data_type);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    }
  }

  return "<br>....Success.<br>";
}


/* For "org_profile" table, use_... fields */
function org_profile_update(){
  $vquery = "SELECT profile_id, industry_id FROM org_profiles";

  try {
    $conn = connect_db();
    $stmt = $conn->query($vquery);
    $rows = $stmt->fetchAll();        
  } 
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }    

  foreach ($rows as $row){
    echo $row["profile_id"] . " ";
    echo $row["industry_id"];
    echo "<br>";

    $sector = $row["industry_id"];
    $pid = $row["profile_id"];

    if ($row["industry_id"] == "Finance and investment" || $row["industry_id"] == "Insurance"){
      $sector = "Finance and insurance";    
      $update_query = "UPDATE org_profiles SET industry_id = :sector WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("sector", $sector);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    } 
    else if ($row["industry_id"] == "Housing & real estate" || $row["industry_id"] == "Housing/real estate"){
      $sector = "Housing, construction & real estate";      
      $update_query = "UPDATE org_profiles SET industry_id = :sector WHERE profile_id=:profile_id";

      try{
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bindParam("profile_id", $pid);
        $stmt2->bindParam("sector", $sector);
        $stmt2->execute();
      } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}<br>'; 
          print_r($update_query);
      }     
    }
  }

  return "<br>....Success.<br>";
}


?>