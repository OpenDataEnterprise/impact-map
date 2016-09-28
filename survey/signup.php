<?php
/*
 * 
 * @usage: http://localhost/codedata/code/timeshareapp/prototypes/s3/signup.php?u=zeus1&pw=123&email=z@gmail.com
 *
 */
session_start();

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


# What's going on?
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

require ('credentials.inc.php');
// parse.com-php-library uses config in vendor/parse.com-php-library/parseConfig.php
require ('vendor/parse.com-php-library/parse.php');

// test values
$_GET['u'] = ''; $_GET['pw'] = ''; $_GET['email'] = "";$_GET['customField'] = "customvalue";

// echo API_KEY;
// echo APPLICATION_ID;

$parseUser = new parseUser;
$parseUser->username = $_GET['u'];
$parseUser->password = $_GET['pw'];
$parseUser->email    = $_GET['email'];
$parseUser->customField = $_GET['customField'];

print_r($parseUser);

try {
    $return = $parseUser->signup();
    // print_r($return);
    if ($return->objectId) {
    	// echo "logged in";
    	$_SESSION['sessionToken'] = $return->sessionToken;
    	$_SESSION['objectId']     = $return->objectId;
    	$_SESSION['username']     = $return->username;
    	$_SESSION['createdAt']    = $return->createdAt;
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    $data = array( "status" => "fail", "error" => $e->getMessage() );
}

// $header('Content-Type: application/json');
echo json_encode($data);
exit();

?>