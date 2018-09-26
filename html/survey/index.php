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
//-------------------------------
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
define("ERROR_LOG_FILE", "/tmp/php-error.log");
ini_set("error_log", ERROR_LOG_FILE);
date_default_timezone_set('America/New_York');
if (!file_exists('credentials.inc.php')) {
   echo "My credentials are missing!";
   exit;
}
// make sure log directory exists and is owned by apache
define("ODESURVEY_LOG", "/var/log/odesurvey/odesurvey.log");
if (!file_exists(ODESURVEY_LOG)) {
  echo "My log file directory ".ODESURVEY_LOG." is missing!";
  exit;
}
$fileinfo = posix_getpwuid(fileowner(ODESURVEY_LOG));
if ($fileinfo['name'] != "apache" && $fileinfo['name'] != "www-data") {
  echo $fileinfo['name'];
  echo "My log file ".ODESURVEY_LOG." is is not owned by Apache!";
  exit;
}

// comment out mailgun temporarily - begin
// // Set if sending email is on
// define("SEND_MAIL", false);
// comment out mailgun temporarily - end
// Include libraries added with composer
require 'vendor/autoload.php';
// Include credentials
require 'credentials.inc.php';
// Include parse library
// require ('vendor/parse.com-php-library_v1/parse.php');
// Include application functions
require 'functions.inc.php';
// comment out mailgun temporarily - begin
// Use Mailgun
// use Mailgun\Mailgun;
// comment out mailgun temporarily - end
# Use Amazon Web Services Ec2 SDK to interact with EC2 instances
# use Aws\Ec2\Ec2Client;

// Functions
//-------------------------------
function TempLogger($message) {
  error_log( "Logger $message" );
}

/* List URLs that you want to make alias for "html" files */
function isURLalias($suburl){
  $aliases = array(
    "/map",
    "/contact",
    "/sectors",
    "/regions",
    "/usecases",
    "/eap",
    "/eca",
    "/lac",
    "/mna",
    "/na",
    "/sar",
    "/afr",
    "/agriculture",
    "/culture",
    "/businessservices",
    "/consumer",
    "/education",
    "/energy",
    "/finance",
    "/governance",
    "/health",
    "/transportation",
    "/media",
    "/it",
    "/housing"
  );
  if (in_array($suburl, $aliases)) {
    return true;
  } else {
    return false;
  }
}

// check if there is suburl after usecases/
function hasSubURL($suburl) {
  if (preg_match('/\/usecases\/.*/', $suburl)) {
    return true;
  } else {
    return false;
  }
}
// Set up basic logging using slim built in logger
// NOTE: Makes sure /var/log/odesurvey/ directory exists and owned by apache:apache
$logWriter = new \Slim\LogWriter(fopen(ODESURVEY_LOG, 'a'));
// Start Slim instance
//-------------------------------
$app = new \Slim\Slim(array('log.writer' => $logWriter));

// Handle not found
$app->notFound(function () use ($app) {

  // Temporarily route /map, /viz to /map.html
  $actual_link = "$_SERVER[REQUEST_URI]";
  if ("/index.html" == "$actual_link" || "/viz/index.html" == "$actual_link") {
    $app->redirect("/map.html");
  }
  // Let's make sure we remove a trailing "/" on any not found paths
    $actual_link = rtrim($actual_link, '/');

  // Any change to below array must also be made to identical array in route "/" around line 210
  if (isURLalias($actual_link)) {
    $app->redirect($actual_link.".html");
  }
  // elseif (isHashURLalias($actual_link)) {
  //   $app->redirect("/survey" . $actual_link);
  // }
  elseif (hasSubURL($actual_link)) {
    $app->redirect("/survey" . $actual_link);
  }
  elseif ($actual_link == "/phpmyadmin"){
    // do nothing...
  } else {
      $app->redirect('/404.html');
    }
});



$app->get('/', function () use ($app) {
  $app->redirect('/survey/form/en_US');
});



$app->get('/error/', function () use ($app) {
  $content['surveyName'] = "opendata";
  $content['title'] = "Open Data Enterprise Survey - Internal Server Error";
  $content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];

  $app->view()->setData(array('content' => $content ));
  $app->render('survey/tp_oops.php');
});



$app->get('/form/', function () use ($app) {
  $app->redirect('/survey/form/en_US');
});



$app->get('/form/:lang/', function ($lang) use ($app) {
  $languages = array(
    'en_US',
    'es_MX',
    'de_DE',
    'pt_BR',
  );

  if (!in_array($lang, $languages)) {
    $app->redirect('/survey/form/en_US');
  }

  $content['surveyName'] = "opendata";
  $content['title'] = "Open Data Enterprise Survey";
  $content['language'] = $lang;

  $app->view()->setData(array('content' => $content));
  $app->render('survey/tp_survey_gettext.php');
});



$app->post('/2du/', function () use ($app) {
  // Access post variables from submitted survey form
  $allPostVars = $app->request->post();

  // Set string values to numeric values
  $allPostVars['org_profile_year'] = intval($allPostVars['org_profile_year']);
  $allPostVars['org_year_founded'] = intval($allPostVars['org_year_founded']);
  $allPostVars['latitude'] = floatval($allPostVars['latitude']);
  $allPostVars['longitude'] = floatval($allPostVars['longitude']);

  // DB Connection
  try {
    $dbh = connect_db();
  } catch (PDOException $e) {
    error_log($e->getMessage());
    $app->redirect("/survey/error/");
  }

  // Retrieve country
  $country_code = isset($allPostVars['org_hq_country_locode']) ? $allPostVars['org_hq_country_locode'] : null;

  if (isset($country_code)) {
    $check_country_query = '
      SELECT *
      FROM country
      WHERE alpha2 = :country_code';

    try {
      $stmt = $dbh->prepare($check_country_query);
      $stmt->bindParam('country_code', $country_code);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (isset($row['id'])) {
        $country_id = $row['id'];
      }
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }
  }

  // Retrieve location
  $name = isset($allPostVars['org_hq_city'])
    ? $allPostVars['org_hq_city'] : null;
  $subnational_division = isset($allPostVars['org_hq_st_prov'])
    ? $allPostVars['org_hq_st_prov'] : null;
  $latitude = isset($allPostVars['latitude'])
    ? $allPostVars['latitude'] : null;
  $longitude = isset($allPostVars['longitude'])
    ? $allPostVars['longitude'] : null;

  if (empty($name) && empty($subnational_division)) {
    $name = isset($allPostVars['org_hq_city_all'])
      ? $allPostVars['org_hq_city_all'] : null;
  }

  if (!empty($name) || !empty($subnational_division)) {
    try {
      $location_query = '
        SELECT *
        FROM location
        WHERE name = :name
          AND subnational_division = :subnational_division';

      $stmt = $dbh->prepare($location_query);
      $stmt->bindParam('name', $name);
      $stmt->bindParam('subnational_division', $subnational_division);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }

    if (isset($row['id'])) {
      $location_id = $row['id'];
    } else {
      $locationInfoQuery = '
        INSERT INTO location (
          country_id,
          name,
          subnational_division,
          latitude,
          longitude
        ) VALUES (
          :country_id,
          :name,
          :subnational_division,
          :latitude,
          :longitude
        )';

      try {
        $stmt1 = $dbh->prepare($locationInfoQuery);
        $stmt1->bindParam('name', $name);
        $stmt1->bindParam('subnational_division', $subnational_division);
        $stmt1->bindParam('country_id', $country_id);
        $stmt1->bindParam('latitude', $latitude);
        $stmt1->bindParam('longitude', $longitude);
        $stmt1->execute();

        $location_id = $dbh->lastInsertId();
      } catch(PDOException $e) {
        error_log($e->getMessage());
        $app->redirect("/survey/error/");
      }
    }
  }

  // Retrieve industry sector
  $sector = isset($allPostVars['industry_id'])
    ? $allPostVars['industry_id'] : null;
  $sector_other = isset($allPostVars['industry_other'])
    ? htmlspecialchars($allPostVars['industry_other']) : null;

  if (isset($sector)) {
    try {
      $sector_query = '
        SELECT *
        FROM sector
        WHERE sector = :sector
          AND other = :other';

      $stmt = $dbh->prepare($sector_query);
      $stmt->bindParam('sector', $sector);
      $stmt->bindParam('other', $sector_other);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (isset($row['id'])) {
        $sector_id = $row['id'];
      }
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }
  }

  // Retrieve organization category
  $category = isset($allPostVars['org_profile_category'])
    ? htmlspecialchars($allPostVars['org_profile_category']) : null;

  if (isset($category)) {
    try {
      $category_query = '
        SELECT *
        FROM category
        WHERE category = :category';

      $stmt = $dbh->prepare($category_query);
      $stmt->bindParam('category', $category);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (isset($row['id'])) {
        $category_id = $row['id'];
      }
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }
  }

  // Retrieve organization type
  $org_type = isset($allPostVars['org_type'])
    ? strval($allPostVars['org_type']) : null;
  $org_type_other = isset($allPostVars['org_type_other'])
    ? htmlspecialchars($allPostVars['org_type_other']) : null;

  if (isset($org_type)) {
    try {
      $org_type_query = '
        SELECT *
        FROM org_type
        WHERE type = :org_type
          AND other = :org_type_other';

      $stmt = $dbh->prepare($org_type_query);
      $stmt->bindParam('org_type', $org_type);
      $stmt->bindParam('org_type_other', $org_type_other);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (isset($row['id'])) {
        $org_type_id = $row['id'];
      }
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }
  }

  // Retrieve organization size
  $org_size = isset($allPostVars['org_size_id'])
    ? strval($allPostVars['org_size_id']) : null;

  if (isset($org_size)) {
    try {
      $org_size_query = '
        SELECT *
        FROM org_size
        WHERE size = :org_size';

      $stmt = $dbh->prepare($org_size_query);
      $stmt->bindParam('org_size', $org_size);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (isset($row['id'])) {
        $org_size_id = $row['id'];
      }
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }
  }

  // Retrieve count of data sources
  $country_count = isset($allPostVars['data_country_count']) ? strval($allPostVars['data_country_count']) : null;

  if (isset($country_count)) {
    try {
      $country_count_query = '
        SELECT *
        FROM country_count
        WHERE count = :country_count';

      $stmt = $dbh->prepare($country_count_query);
      $stmt->bindParam('country_count', $country_count);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (isset($row['id'])) {
        $country_count_id = $row['id'];
      }
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }
  }

  // Retrieve status
  $status = isset($allPostVars['org_profile_status']) ? strval($allPostVars['org_profile_status']): null;

  if (isset($status)) {
    try {
      $status_query = '
        SELECT *
        FROM status
        WHERE status = :status';

      $stmt = $dbh->prepare($status_query);
      $stmt->bindParam('status', $status);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (isset($row['id'])) {
        $status_id = $row['id'];
      }
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }
  }

  $org_name = isset($allPostVars['org_name']) ? htmlspecialchars($allPostVars['org_name']) : null;
  $org_additional = isset($allPostVars['org_additional']) ? $allPostVars['org_additional']: null;
  $org_description = isset($allPostVars['org_description']) ? htmlspecialchars($allPostVars['org_description']) : null;
  $org_greatest_impact = isset($allPostVars['org_greatest_impact']) ? htmlspecialchars($allPostVars['org_greatest_impact']) : null;
  $org_greatest_impact_detail = isset($allPostVars['org_greatest_impact_detail']) ? htmlspecialchars($allPostVars['org_greatest_impact_detail']) : null;
  $org_profile_src = isset($allPostVars['org_profile_src']) ? htmlspecialchars($allPostVars['org_profile_src']) : null;
  $org_profile_year = isset($allPostVars['org_profile_year']) ? intval($allPostVars['org_profile_year']): null;
  $org_url = isset($allPostVars['org_url']) ? strval($allPostVars['org_url']) : null;
  $org_year_founded = isset($allPostVars['org_year_founded']) ? intval($allPostVars['org_year_founded']): null;
  $machine_readable = isset($allPostVars['m_read']) ? $allPostVars['m_read'] : null;

  $org_profile_query = '
    INSERT INTO profile (
      location_id,
      sector_id,
      category_id,
      org_type_id,
      org_size_id,
      country_count_id,
      status_id,
      org_additional,
      org_description,
      org_greatest_impact,
      org_greatest_impact_detail,
      org_name,
      org_profile_source,
      org_profile_year,
      org_url,
      org_year_founded,
      machine_readable
    ) VALUES (
      :location_id,
      :sector_id,
      :category_id,
      :org_type_id,
      :org_size_id,
      :country_count_id,
      :status_id,
      :org_additional,
      :org_description,
      :org_greatest_impact,
      :org_greatest_impact_detail,
      :org_name,
      :org_profile_source,
      :org_profile_year,
      :org_url,
      :org_year_founded,
      :machine_readable
    )';

  try {
    $stmt = $dbh->prepare($org_profile_query);
    $stmt->bindParam('location_id', $location_id);
    $stmt->bindParam('sector_id', $sector_id);
    $stmt->bindParam('category_id', $category_id);
    $stmt->bindParam('org_type_id', $org_type_id);
    $stmt->bindParam('org_size_id', $org_size_id);
    $stmt->bindParam('country_count_id', $country_count_id);
    $stmt->bindParam('status_id', $status_id);
    $stmt->bindParam('org_additional', $org_additional);
    $stmt->bindParam('org_description', $org_description);
    $stmt->bindParam('org_greatest_impact', $org_greatest_impact);
    $stmt->bindParam('org_greatest_impact_detail', $org_greatest_impact_detail);
    $stmt->bindParam('org_name', $org_name);
    $stmt->bindParam('org_profile_source', $org_profile_src);
    $stmt->bindParam('org_profile_year', $org_profile_year);
    $stmt->bindParam('org_url', $org_url);
    $stmt->bindParam('org_year_founded', $org_year_founded);
    $stmt->bindParam('machine_readable', $machine_readable);
    $stmt->execute();

    $profile_id = $dbh->lastInsertId();
    $app->log->info(date_format(date_create(), 'Y-m-d H:i:s') . '; INFO; ' . str_replace('\n', '||', print_r('Survey ' . strval($profile_id) . ' created.', true)));
  } catch(PDOException $e) {
    error_log($e->getMessage());
    $app->redirect("/survey/error/");
  }

  /* org_contacts */
  $survey_contact_first = isset($allPostVars['survey_contact_first'])
    ? htmlspecialchars($allPostVars['survey_contact_first']) : null;
  $survey_contact_last =  isset($allPostVars['survey_contact_last'])
    ? htmlspecialchars($allPostVars['survey_contact_last']) : null;
  $survey_contact_title = isset($allPostVars['survey_contact_title'])
    ? htmlspecialchars($allPostVars['survey_contact_title']) : null;
  $survey_contact_email = isset($allPostVars['survey_contact_email'])
    ? htmlspecialchars($allPostVars['survey_contact_email']) : null;
  $survey_contact_phone = isset($allPostVars['survey_contact_phone'])
    ? htmlspecialchars($allPostVars['survey_contact_phone']) : null;

  // Checking existing data
  $contact_query = '
    SELECT *
    FROM contact
    WHERE profile_id = :profile_id';

  try {
    $stmt = $dbh->prepare($contact_query);
    $stmt->bindParam('profile_id', $profile_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($row['id'])) {
      $contact_upsert_query = '
        UPDATE contact
        SET
          survey_contact_first = :survey_contact_first,
          survey_contact_last = :survey_contact_last,
          survey_contact_title = :survey_contact_title,
          survey_contact_email = :survey_contact_email,
          survey_contact_phone = :survey_contact_phone
        WHERE profile_id = :profile_id';
    } else {
      $contact_upsert_query = '
        INSERT INTO contact (
          `profile_id`,
          `firstname`,
          `lastname`,
          `title`,
          `email`,
          `phone`
        ) VALUES (
          :profile_id,
          :survey_contact_first,
          :survey_contact_last,
          :survey_contact_title,
          :survey_contact_email,
          :survey_contact_phone
        )';
    }

    try {
      $stmt = $dbh->prepare($contact_upsert_query);
      $stmt->bindParam('profile_id', $profile_id);
      $stmt->bindParam('survey_contact_first', $survey_contact_first);
      $stmt->bindParam('survey_contact_last', $survey_contact_last);
      $stmt->bindParam('survey_contact_title', $survey_contact_title);
      $stmt->bindParam('survey_contact_email', $survey_contact_email);
      $stmt->bindParam('survey_contact_phone', $survey_contact_phone);
      $stmt->execute();
    } catch (PDOException $e) {
      error_log($e->getMessage());
      $app->redirect("/survey/error/");
    }
  } catch (PDOException $e) {
    error_log($e->getMessage());
    $app->redirect("/survey/error/");
  }

  /* Data Applications */
  $use_advocacy = (!isset($allPostVars['use_advocacy']) || empty($allPostVars['use_advocacy'])) ? 0 : 1;
  $use_prod_srvc = (!isset($allPostVars['use_prod_srvc']) || empty($allPostVars['use_prod_srvc'])) ? 0 : 1;
  $use_research = (!isset($allPostVars['use_research']) || empty($allPostVars['use_research'])) ? 0 : 1;
  $use_org_opt = (!isset($allPostVars['use_org_opt']) || empty($allPostVars['use_org_opt'])) ? 0 : 1;
  $use_other = (!isset($allPostVars['use_other']) || empty($allPostVars['use_other'])) ? 0 : 1;

  $use_advocacy_desc = isset($allPostVars['use_advocacy_desc']) ? htmlspecialchars($allPostVars['use_advocacy_desc']) : null;
  $use_org_opt_desc = isset($allPostVars['use_org_opt_desc']) ? htmlspecialchars($allPostVars['use_org_opt_desc']) : null;
  $use_other_desc = isset($allPostVars['use_other_desc']) ? htmlspecialchars($allPostVars['use_other_desc']) : null;
  $use_prod_srvc_desc = isset($allPostVars['use_prod_srvc_desc']) ? htmlspecialchars($allPostVars['use_prod_srvc_desc']) : null;
  $use_research_desc = isset($allPostVars['use_research_desc']) ? htmlspecialchars($allPostVars['use_research_desc']) : null;

  // Checking existing data
  $data_application_query = '
    SELECT *
    FROM data_application
    WHERE profile_id = :profile_id';

  try {
    $stmt = $dbh->prepare($data_application_query);
    $stmt->bindParam('profile_id', $profile_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($row['id'])) {
      $data_application_upsert_query = '
        UPDATE data_application
        SET
          advocacy = :use_advocacy,
          advocacy_desc = :use_advocacy_desc,
          org_opt = :use_org_opt,
          org_opt_desc = :use_org_opt_desc,
          use_other = :use_other,
          use_other_desc = :use_other_desc,
          prod_srvc = :use_prod_srvc,
          prod_srvc_desc = :use_prod_srvc_desc,
          research = :use_research,
          research_desc = :use_research_desc
        WHERE profile_id = :profile_id';
    } else {
      $data_application_upsert_query = '
        INSERT INTO data_application (
          profile_id,
          advocacy,
          advocacy_desc,
          org_opt,
          org_opt_desc,
          use_other,
          use_other_desc,
          prod_srvc,
          prod_srvc_desc,
          research,
          research_desc
        ) VALUES (
          :profile_id,
          :use_advocacy,
          :use_advocacy_desc,
          :use_org_opt,
          :use_org_opt_desc,
          :use_other,
          :use_other_desc,
          :use_prod_srvc,
          :use_prod_srvc_desc,
          :use_research,
          :use_research_desc
        )';
    }
  } catch (PDOException $e) {
    error_log($e->getMessage());
    $app->redirect("/survey/error/");
  }

  try {
    $stmt = $dbh->prepare($data_application_upsert_query);
    $stmt->bindParam('profile_id', $profile_id);
    $stmt->bindParam('use_advocacy', $use_advocacy);
    $stmt->bindParam('use_advocacy_desc', $use_advocacy_desc);
    $stmt->bindParam('use_org_opt', $use_org_opt);
    $stmt->bindParam('use_org_opt_desc', $use_org_opt_desc);
    $stmt->bindParam('use_other', $use_other);
    $stmt->bindParam('use_other_desc', $use_other_desc);
    $stmt->bindParam('use_prod_srvc', $use_prod_srvc);
    $stmt->bindParam('use_prod_srvc_desc', $use_prod_srvc_desc);
    $stmt->bindParam('use_research', $use_research);
    $stmt->bindParam('use_research_desc', $use_research_desc);
    $stmt->execute();
  } catch (PDOException $e) {
    error_log($e->getMessage());
    $app->redirect("/survey/error/");
  }

  $idSuffixNum = 1;
  $type_to_input = array();

  while (array_key_exists('dataUseData-' . $idSuffixNum, $allPostVars)) {
    $data_use_type = isset($allPostVars['data_use_type'])
      ? $allPostVars['data_use_type'] : null;
    $data_use_type_other = isset($allPostVars['data_use_type_other'])
      ? $allPostVars['data_use_type_other'] : null;

    if (isset($allPostVars['dataUseData-'.$idSuffixNum])) {
      foreach ($allPostVars['dataUseData-'.$idSuffixNum] as $row) {
        // Country Search
        $src_country_locode = strval($row['src_country_locode']);
        $src_country_name = addWbRegions($src_country_locode);

        $country_query = '
          SELECT *
          FROM country
          WHERE name = :src_country_name';

        try {
          $stmt = $dbh->prepare($country_query);
          $stmt->bindParam('src_country_name', $src_country_name['org_hq_country_name']);
          $stmt->execute();
          $rows = $stmt->fetch(PDO::FETCH_ASSOC);

          if (isset($rows['id'])) {
            $country_id = $rows['id'];
          }

          $temp[$country_id] = array();
          foreach ($data_use_type as $type) {
            if (isset($row['type'][$type])) {
              foreach ($row['type'][$type]['src_gov_level'] as $k=>$v) {
                $temp[$country_id][$type][$k] = $v;
              }
            } else {
              $temp[$country_id][$type] = null;
            }
          }
          array_push($type_to_input, $temp);
        } catch (PDOException $e) {
          error_log($e->getMessage());
          $app->redirect("/survey/error/");
        }
      }
    }

    $idSuffixNum++;
  }

  /* Inserting into the Data Use Table */
  $delete_query = '
    DELETE FROM data_source
    WHERE profile_id = :profile_id';

  try {
    $stmt = $dbh->prepare($delete_query);
    $stmt->bindParam('profile_id', $profile_id);
    $stmt->execute();
  } catch(PDOException $e) {
    error_log($e->getMessage());
    $app->redirect("/survey/error/");
  }

  $other = isset($allPostVars['data_use_type_other']) ? htmlspecialchars($allPostVars['data_use_type_other']) : null;

  if (isset($type_to_input[0])) {
    foreach ($type_to_input[0] as $country_id => $types) {
      foreach ($types as $type => $scopes) {
        $data_type_query = '
          SELECT *
          FROM data_type
          WHERE data_type = :data_type
            AND data_type_other = :data_type_other';

        try {
          $stmt = $dbh->prepare($data_type_query);
          $stmt->bindParam('data_type', $type);
          if ($type == 'Other') {
            $stmt->bindParam('data_type_other', $other);
          } else {
            $stmt->bindParam('data_type_other', null);
          }
          $stmt->execute();
          $rows = $stmt->fetch(PDO::FETCH_ASSOC);

          if (isset($rows['id'])) {
            $data_type_id = $rows['id'];
          }
        } catch (PDOException $e) {
          error_log($e->getMessage());
          $app->redirect("/survey/error/");
        }

        foreach ($scopes as $data_scope) {
          $data_source_query = '
            INSERT INTO data_source (
              profile_id,
              country_id,
              data_type_id,
              data_scope,
              machine_readable
            ) VALUES (
              :profile_id,
              :country_id,
              :data_type_id,
              :data_scope,
              :machine_readable
            )';

          try {
            $stmt = $dbh->prepare($data_use_query);
            $stmt->bindParam('profile_id', $profile_id);
            $stmt->bindParam('country_id', $country_id);
            $stmt->bindParam('data_type_id', $data_type_id);
            if (isset($data_scope)) {
              $stmt->bindParam('data_scope', $data_scope);
            } else {
              $stmt->bindParam('data_scope', null);
            }
            $stmt->bindParam('machine_readable', $machine_readable);
            $stmt->execute();
          } catch (PDOException $e) {
            error_log($e->getMessage());
            $app->redirect("/survey/error/");
          }
        }
      }
    }
  }

  $app->redirect('/survey/submitted/' . $profile_id);
});



// Submission confirmation page.
$app->get('/submitted/:surveyId/', function ($profile_id) use ($app) {
  $content['surveyId'] = $profile_id;
  $content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
  $content['surveyName'] = "opendata";
  $content['title'] = "Open Data Enterprise Survey - Thank You";
  $content['language'] = "en_US";
  $app->view()->setData(array('content' => $content));
  $app->render('survey/tp_thankyou.php');
});



$app->get('/:surveyId/submitted/', function ($profile_id) use ($app) {
    $db = connect_db();
    $org_profile_query="select * from org_profiles where object_id=?";
    $stmt = $db->prepare($org_profile_query);
    $stmt->bindParam(1, $profile_id);
    $stmt->execute();
    $query_results = $stmt->fetchAll();
    $request_decoded = json_decode($query_results, true);
      $org_profile = $request_decoded['results'][0];
    $db = connect_db();
    $org_data_use_query="select * from org_data_sources where object_id=?";
    $stmt = $db->prepare($org_data_use_query);
    $stmt->bindParam(1, $profile_id);
    $stmt->execute();
    $query_results_data = $stmt->fetchAll();
    $request_decoded = json_decode($query_results_data, true);
      $org_data_use = $request_decoded['results'][0];
    $content['surveyId'] = $profile_id;
    $content['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
    $content['surveyName'] = "opendata";
    $content['title'] = "Open Data Enterprise Survey - Submitted";
    $content['language'] = "en_US";

  $app->view()->setData(array('content' => $content, 'org_profile' => $org_profile, 'org_data_use' => $org_data_use ));
  $app->render('survey/tp_submitted.php');
});



$app->get('/showduplicates', function () use ($app) {
  $db = connect_db();

  $org_profile_query = '
    SELECT
      profile_id,
      org_name,
      createdAt
    FROM org_profiles
    WHERE org_profile_status = "publish"
    ORDER BY profile_id DESC';

  $stmt = $db->prepare($org_profile_query);
  $stmt->execute();
  $org_profile = $stmt->fetchAll();

  $names = array();

  foreach ($org_profile as $item) {
    if (in_array($item["org_name"], $names)) {
      echo strval($item["profile_id"]) . ": " . $item["org_name"] . ", inserted on " . strval($item["createdAt"]);
      echo "<br>";
    } else {
      array_push($names, $item["org_name"]);
    }
  }
});



// ************** on development.. by Myeong .. .
$app->get('/data/flatfile.json', function () use ($app) {
  $db = connect_db();
  $db->exec('set names utf8');
  $org_profile_query = "
    SELECT
      p.id AS profile_id,
      l.name AS location,
      l.subnational_division,
      l.latitude AS location_latitude,
      l.longitude AS location_longitude,
      c.name AS country,
      c.alpha3,
      c.latitude AS country_latitude,
      c.longitude AS country_longitude,
      r.name AS region,
      il.income_level,
      il.abbreviation AS income_code,
      s.sector,
      s.other AS sector_other,
      ctg.category,
      os.size,
      ot.type,
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
      p.org_additional,
      p.org_confidence,
      p.org_description,
      p.org_greatest_impact,
      p.org_greatest_impact_detail,
      p.org_name,
      p.org_profile_source,
      p.org_profile_year,
      p.org_url,
      p.org_year_founded,
      p.machine_readable,
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
    LEFT JOIN category AS ctg ON p.category_id = ctg.id
    LEFT JOIN org_size AS os ON p.org_size_id = os.id
    LEFT JOIN org_type AS ot ON p.org_type_id = ot.id
    LEFT JOIN data_application AS da ON p.id = da.profile_id
    LEFT JOIN status AS st ON p.status_id = st.id
    WHERE st.status = 'publish'";
  $stmt = $db->prepare($org_profile_query);
  $stmt->execute();
  $org_profiles = $stmt->fetchAll();
  $final_array = array();

  // Data Use
  foreach ($org_profiles as $profile) {
    $properties = array();
    $createdAt = explode(' ',  $profile['created_at']);
    $updatedAt = explode(' ',  $profile['updated_at']);
    $properties['createdAt'] = $createdAt[0];
    $properties['industry_id'] = $profile['sector'];
    $properties['industry_other'] = $profile['sector_other'];
    $properties['latitude'] =
      (floatval($profile['location_latitude']) != 0)
        ? floatval($profile['location_latitude'])
        : floatval($profile['country_latitude']);
    $properties['longitude'] =
      (floatval($profile['location_longitude']) != 0)
        ? floatval($profile['location_longitude'])
        : floatval($profile['country_longitude']);
    $properties['org_description'] = $profile['org_description'];
    $properties['org_greatest_impact'] = $profile['org_greatest_impact'];
    $properties['org_greatest_impact_detail'] =
      $profile['org_greatest_impact_detail'];
    $properties['org_hq_city'] = $profile['location'];
    // $properties['org_hq_city_locode'] = null;
    $properties['org_hq_country'] = $profile['country'];
    $properties['org_hq_country_income'] = $profile['income_level'];
    $properties['org_hq_country_income_code'] = $profile['income_code'];
    $properties['org_hq_country_locode'] = $profile['alpha3'];
    $properties['org_hq_country_region'] = $profile['region'];
    // $properties['org_hq_country_region_code'] = $profile['org_hq_country_region_code'];
    $properties['org_hq_st_prov'] = $profile['subnational_division'];
    $properties['org_name'] = $profile['org_name'];
    //$properties['org_open_corporates_id'] = null;
    $properties['org_profile_category'] = $profile['category'];
    $properties['org_profile_src'] = $profile['org_profile_source'];
    $properties['org_profile_status'] = $profile['status'];
    $properties['org_profile_year'] = intval($profile['org_profile_year']);
    $properties['org_size_id'] = $profile['size'];
    $properties['org_type'] = $profile['type'];
    $properties['org_type_other'] = $profile['type_other'];
    $properties['org_url'] = $profile['org_url'];
    $properties['org_year_founded'] = intval($profile['org_year_founded']);
    $properties['profile_id'] = intval($profile['profile_id']);
    $properties['row_type'] = 'org_profile';
    $properties['updated_at'] = $updatedAt[0];
    $properties['use_advocacy'] = intval($profile['advocacy']);
    $properties['use_advocacy_desc'] = $profile['advocacy_desc'];
    $properties['use_org_opt'] = intval($profile['org_opt']);
    $properties['use_org_opt_desc'] = $profile['org_opt_desc'];
    $properties['use_other'] = intval($profile['use_other']);
    $properties['use_other_desc'] = $profile['use_other_desc'];
    $properties['use_prod_srvc'] = intval($profile['prod_srvc']);
    $properties['use_prod_srvc_desc'] = $profile['prod_srvc_desc'];
    $properties['use_research'] = intval($profile['research']);
    $properties['use_research_desc'] = $profile['research_desc'];
    $properties['date_created'] = $createdAt[0];
    $properties['date_modified'] = $updatedAt[0];
    $properties['eligibility'] = 'YY';
    $properties['org_additional'] = $profile['org_additional'];
    $properties['org_confidence'] = intval($profile['org_confidence']);
    // $properties['data_country_count'] = intval($profile['data_country_count']);
    $properties['machine_read'] = $profile['machine_readable'];
    array_push($final_array, $properties);

    $data_use_query = '
      SELECT *
      FROM org_data_use AS u
      LEFT JOIN org_country_info as c ON u.src_country_id = c.country_id
      WHERE profile_id = :pid';
    $stmt2 = $db->prepare($data_use_query);
    $stmt2->bindParam('pid', $item['profile_id']);
    $stmt2->execute();
    $data_use = $stmt2->fetchAll();

    foreach ($data_use as $use) {
      $use_temp = array();
      $createdAt = explode(' ',  $profile['created_at']);
      $updatedAt = explode(' ',  $profile['updated_at']);
      $use_temp['createdAt'] = $createdAt[0];
      $use_temp['industry_id'] = $profile['sector'];
      $use_temp['industry_other'] = $profile['sector_other'];
      $use_temp['latitude'] =
        (floatval($profile['latitude']) != 0)
          ? floatval($profile['location_latitude'])
          : floatval($profile['country_latitude']);
      $use_temp['longitude'] =
        (floatval($profile['location_longitude']) != 0)
          ? floatval($profile['location_longitude'])
          : floatval($profile['country_longitude']);
      $use_temp['org_description'] = $profile['org_description'];
      $use_temp['org_greatest_impact'] = $profile['org_greatest_impact'];
      $use_temp['org_greatest_impact_detail'] =
        $profile['org_greatest_impact_detail'];
      $use_temp['org_hq_city'] = $profile['location'];
      $use_temp['org_hq_country'] = $profile['country'];
      $use_temp['org_hq_country_income'] = $profile['income_level'];
      $use_temp['org_hq_country_income_code'] = $profile['income_code'];
      $use_temp['org_hq_country_locode'] = $profile['alpha3'];
      $use_temp['org_hq_country_region'] = $profile['region'];
      $use_temp['org_hq_st_prov'] = $profile['subnational_division'];
      $use_temp['org_name'] = $profile['org_name'];
      $use_temp['org_profile_category'] = $profile['category'];
      $use_temp['org_profile_src'] = $profile['org_profile_source'];
      $use_temp['org_profile_status'] = $profile['status'];
      $use_temp['org_profile_year'] = intval($profile['org_profile_year']);
      $use_temp['org_size_id'] = $profile['size'];
      $use_temp['org_type'] = $profile['type'];
      $use_temp['org_type_other'] = $profile['type_other'];
      $use_temp['org_url'] = $profile['org_url'];
      $use_temp['org_year_founded'] = intval($profile['org_year_founded']);
      $use_temp['profile_id'] = intval($profile['id']);
      $use_temp['row_type'] = 'org_profile';
      $use_temp['updated_at'] = $updatedAt[0];
      $use_temp['use_advocacy'] = intval($profile['advocacy']);
      $use_temp['use_advocacy_desc'] = $profile['advocacy_desc'];
      $use_temp['use_org_opt'] = intval($profile['org_opt']);
      $use_temp['use_org_opt_desc'] = $profile['org_opt_desc'];
      $use_temp['use_other'] = intval($profile['use_other']);
      $use_temp['use_other_desc'] = $profile['use_other_desc'];
      $use_temp['use_prod_srvc'] = intval($profile['prod_srvc']);
      $use_temp['use_prod_srvc_desc'] = $profile['prod_srvc_desc'];
      $use_temp['use_research'] = intval($profile['research']);
      $use_temp['use_research_desc'] = $profile['research_desc'];
      $use_temp['date_created'] = $createdAt[0];
      $use_temp['date_modified'] = $updatedAt[0];
      $use_temp['eligibility'] = 'YY';
      $use_temp['org_additional'] = $profile['org_additional'];
      $use_temp['org_confidence'] = intval($profile['org_confidence']);
      $use_temp['machine_read'] = $profile['machine_readable'];
      $use_temp['data_src_country_locode'] = $use['alpha3'];
      $use_temp['data_src_country_name'] = $use['data_country'];
      $use_temp['data_src_gov_level']= $use['data_scope'];
      $use_temp['data_type']= $use['data_type'];
      $use_temp['data_use_type_other'] = $use['data_type_other'];
      array_push($final_array, $use_temp);
    }
  }

  $jsonArray = array('results' => $final_array);
  echo json_encode($jsonArray);
});



$app->get('/argis/auth/', function () use ($app) {
  $params = array(
      'client_id' => ArcGIS_CLIENT_ID,
      'client_secret' => ArcGIS_CLIENT_SECRET,
      'grant_type' => 'client_credentials',
      'f' => 'json'
  );
  try {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://www.arcgis.com/sharing/oauth2/token/");
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, true);
      $response = curl_exec($ch);
  } catch (Exception $e) {
      error_log($e->getMessage(), 0);
  }
  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $body = substr($response, $header_size);
  $json = json_decode($body, true);
  $token = $json['access_token'];
  echo $token;
});



$app->get('/argis/geoservice/', function () use ($app) {
  $params = array(
      'client_id' => ArcGIS_CLIENT_ID,
      'client_secret' => ArcGIS_CLIENT_SECRET,
      'grant_type' => 'client_credentials',
      'f' => 'json'
  );
  try {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://www.arcgis.com/sharing/oauth2/token/");
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, true);
      $response = curl_exec($ch);
  } catch (Exception $e) {
      error_log($e->getMessage(), 0);
  }
  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $body = substr($response, $header_size);
  $json = json_decode($body, true);
  $token = $json['access_token'];
  echo $token;
});



$app->run();
