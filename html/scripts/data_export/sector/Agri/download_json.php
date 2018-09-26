<?php
  include_once('../../../../survey/credentials.inc.php');
  include_once('../../../../survey/connect_db.php');

  $date = date('Y_m_d');
  // This is for the filename.
  $title = 'Agriculture';
  // This is for querying.
  $sector = 'Agriculture';

  header('Content-Type: application/json');
  header('Content-Disposition: attachment; filename='
    . 'Open Data Impact Map_Data Export_' . $title . '_' . $date
    . '.json');

  $dbh = connect_db();

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

  $sql = "
    SELECT
      p.id AS profile_id,
      l.name AS location,
      l.subnational_division,
      c.name AS country,
      r.name AS region,
      il.income_level,
      s.sector,
      s.other AS sector_other,
      os.size AS org_size,
      ot.type AS org_type,
      ot.other AS type_other,
      da.advocacy,
      da.advocacy_desc,
      da.org_opt,
      da.org_opt_desc,
      da.use_other,
      da.use_other_desc,
      da.prod_srvc,
      da.prod_srvc_desc,
      da.research,
      da.research_desc,
      p.org_description,
      p.org_name,
      p.org_url,
      p.org_year_founded,
      st.status,
      p.created_at,
      p.updated_at
    FROM profile AS p
    LEFT JOIN location AS l ON p.location_id = l.id
    LEFT JOIN country AS c ON l.country_id = c.id
    LEFT JOIN country_count AS cc ON p.country_count_id = cc.id
    LEFT JOIN income_level AS il ON c.income_level_id = il.id
    LEFT JOIN region AS r ON c.region_id = r.id
    LEFT JOIN sector AS s ON p.sector_id = s.id
    LEFT JOIN org_size AS os ON p.org_size_id = os.id
    LEFT JOIN org_type AS ot ON p.org_type_id = ot.id
    LEFT JOIN data_application AS da ON p.id = da.profile_id
    LEFT JOIN status AS st ON p.status_id = st.id
    WHERE s.sector = :sector
      AND st.status = 'publish'";

  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':sector', $sector);
  $stmt->execute();

  $profiles = [];
  $rows = $stmt->fetchAll();

  foreach ($rows as $i => $row) {
    $profiles[] = new orgProfile();
    $profiles[$i]->Sector = $row['sector'];
    $profiles[$i]->Organization_description = $row['org_description'];
    $profiles[$i]->Organization_name = $row['org_name'];
    $pattern = '/-/';
    $replacement = ' to ';
    $profiles[$i]->Size = preg_replace($pattern, $replacement, $row['org_size']);
    $profiles[$i]->Type_of_organization = $row['org_type'];
    $profiles[$i]->URL = $row['org_url'];
    $profiles[$i]->Founding_year = $row['org_year_founded'];
    // convert 1 and 0 to true false string for better presentation for CSV users
    // app 1
    if ($row['advocacy'] == 0) {
      $profiles[$i]->Application_Advocacy = 'FALSE';
    } else {
      $profiles[$i]->Application_Advocacy = 'TRUE';
    }
    $profiles[$i]->Advocacy_description = $row['advocacy_desc'];
    // app 2
    if ($row['org_opt'] == 0) {
      $profiles[$i]->Application_Organizational_Optimization = 'FALSE';
    } else {
      $profiles[$i]->Application_Organizational_Optimization = 'TRUE';
    }
    $profiles[$i]->Organizational_Optimization_Description = $row['org_opt_desc'];
    // app 3
    if ($row['use_other'] == 0) {
      $profiles[$i]->Application_Other = 'FALSE';
    } else {
      $profiles[$i]->Application_Other = 'TRUE';
    }
    $profiles[$i]->Other_Description = $row['use_other_desc'];
    // app 4
    if ($row['prod_srvc'] == 0) {
      $profiles[$i]->Application_Product_Service = 'FALSE';
    } else {
      $profiles[$i]->Application_Product_Service = 'TRUE';
    }
    $profiles[$i]->Product_Service_Description = $row['prod_srvc_desc'];
    // app5
    if ($row['research'] == 0) {
      $profiles[$i]->Application_Research = 'FALSE';
    } else {
      $profiles[$i]->Application_Research = 'TRUE';
    }
    $profiles[$i]->Research_Description = $row['research_desc'];
    // all apps finished converting
    $profiles[$i]->Country = $row['country'];
    $profiles[$i]->Country_income_level = $row['income_level'];
    $profiles[$i]->Region = $row['region'];
    $profiles[$i]->City = $row['location'];
    $profiles[$i]->State_County = $row['subnational_division'];
  }

  // insert data type data
  $sql = "SELECT
      p.org_name,
      dt.data_type
    FROM profile AS p
    JOIN data_source AS ds ON ds.profile_id = p.id
    JOIN data_type AS dt ON dt.id = ds.data_type_id
    JOIN status AS st ON st.id = p.status_id
    WHERE st.status = 'publish'";

  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $rows = $stmt->fetchAll();
  foreach ($rows as $row) {
    foreach ($profiles as $profile) {
      if ($profile->Organization_name == $row["org_name"]) {
        if (isset($profile->Type_of_data_used)) {
          if (strstr($row["data_type"], $profile->Type_of_data_used) == FALSE) {
            if ($row["data_type"] != "") {
              $profile->Type_of_data_used = $profile->Type_of_data_used . ", "
                . $row["data_type"];
            }
          }
        } else {
          $profile->Type_of_data_used = $profile->Type_of_data_used
            . $row["data_type"];
        }
      }
    }
  }

  echo json_encode($profiles, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
