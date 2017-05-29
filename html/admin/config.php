<?php
date_default_timezone_set('America/New_York'); 

ini_set("display_errors", "off");
require_once "../survey/credentials.inc.php";
require __DIR__ . "/src/LS.php";

$LS = new \Fr\LS(array(
  "basic" => array(
    "company" => "Vinayak Website",
    "email" => "vinayak.mpande@yahoo.com",
/*    "email_callback" => function($LS, $email, $subject, $body){
  mail($email, $subject . " - My Company", $body);
}*/
  ),
  "db" => array(
    "host" => DBHOST,
    //"host" => "******t",
    "port" => 3306,
    "username" => DBUSER,
    //"username" => "r******",
    "password" => DBPASS,
    //"password" => "S******",
    "name" => DBNAME,
    //"name" => "o******",
    "table" => "users"
  ),
  "features" => array(
    // "auto_init" => true,
    "auto_init" => false,
  ),

  "pages" => array(
    "no_login" => array(
      "/",
      "/examples/basic/reset.php",
      "/examples/basic/register.php"
    ),
    "everyone" => array(
      "/examples/two-step-login/status.php",
    ),
    "login_page" => "login.php",
    "home_page" => "home.php"
  )
));


