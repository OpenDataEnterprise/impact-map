<?php

define("DBHOST", "localhost");
  define("DBNAME", "ode_survey");
  define("DBUSER", "root");
  define("DBPASS", "Sep@2016");
  
  $db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

  if($db->connect_errno > 0){
      die('Unable to connect to database [' . $db->connect_error . ']');
  }


?>