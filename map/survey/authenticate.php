<?php
session_start();

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require ('credentials.inc.php');
require ('vendor/parse.com-php-library/parse.php');
$loginUser = new parseUser;
$loginUser->username = $_POST['u'];
$loginUser->password = $_POST['pw'];

// print_r($loginUser);
    echo "logifffn";
try {
    // $return = $loginUser->login();
    // // print_r($return);
    // if ($return->objectId) {
    // 	// echo "logged in";
    // 	$_SESSION['sessionToken'] = $return->sessionToken;
    // 	$_SESSION['objectId']     = $return->objectId;
    // 	$_SESSION['username']     = $return->username;
    // 	$_SESSION['createdAt']    = $return->createdAt;
    // }
   // $_SESSION['username'] = "pooja";
   // $data = $return;
    echo "login";
    // login successful
    // echo "<br> here ==========<br>";
    // print_r($loginUser);
    // echo "<br> here ==========<br>";
    // print_r($data);
    // exit;
    header( 'Location: /map/survey/admin/protected' );


} catch (Exception $e) {
    echo "heyyy
    // echo 'Caught exception: ',  $e->getMessage(), "\n";
    $_SESSION['sessionToken'] = null;
    $_SESSION['objectId']     = null;
    $_SESSION['username']     = null;
    $_SESSION['error']        = $e->getMessage();

    $data['sessionToken'] = null;
    $data['objectId']     = null;
    $data['username']     = null;
    $data['error']        = $e->getMessage();

    echo "Error logging in.<br>";
    echo $data['error'];
   // echo "<p><a href='/map/survey/admin/login/'>Return to login</p>";
}

?>