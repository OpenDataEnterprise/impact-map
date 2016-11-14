<?php

error_reporting(E_ALL);
define("ERROR_LOG_FILE", "/tmp/php-error.log");
ini_set("error_log", ERROR_LOG_FILE);
date_default_timezone_set('America/New_York'); 

// I18N support information here
$language = "es_MX";
putenv("LANG=" . $language); 
setlocale(LC_ALL, $language);
 
// Set the text domain as "messages"
$domain = "messages";
bindtextdomain($domain, "Locale"); 
bind_textdomain_codeset($domain, 'UTF-8');
 
textdomain($domain);

echo "<br>201-1000";

echo _("201-1000");

echo "<br>NONPROFIT ";

echo _("NONPROFIT");


echo "<br>";

echo _("GOVERNMENT_OPS");

echo "<br>";

echo _("ELIGIBILITY");

echo "<br>";

echo _("INFO_COLLECTED");
