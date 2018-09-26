<?php
require 'credentials.inc.php';

function connect_db() {
  $dbhost = DBHOST;
  $dbname = DBNAME;
  $dbuser = DBUSER;
  $dbpass = DBPASS;
  $dbh = "";

  try {
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->exec("set names utf8");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    error_log($e->getMessage());
    throw $e;
  }

  return $dbh;
}
