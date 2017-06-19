<?php
require_once "../../../../survey/credentials.inc.php";
?>
<html>  
<head>

  <title> Edit Data Use</title>

</head>
<body>
<H1 style="text-align: center;">Test Page</H1>

<?php

ini_set('display_errors', 1);

$AGOLENV = 'development';

putenv("AGOL_USER=$AGOLUSER");
shell_exec("export AGOL_USER");

putenv("AGOL_PASS=$AGOLPASS");
shell_exec("export AGOL_PASS");

putenv("AGOL_ENV=$AGOLENV");
shell_exec("export AGOL_ENV");

$user = getenv('AGOL_USER');
$pass = getenv('AGOL_PASS');
$env = getenv('AGOL_ENV');

echo "</br>AGOL_USER " . $user;
echo "</br>AGOL_PASS " . $pass;
echo "</br>AGOL_ENV " . $env. "</br>";

//echo exec('sudo python /home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py');

/*$output = shell_exec("/home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py");
echo $output;
*/
passthru('python /home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py  2>&1');

passthru('python ../../../../../../../home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py  2>&1');

/*$command = escapeshellcmd('/home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py');
$output = shell_exec($command);
echo $output;

echo exec('/home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py');

ob_start();
passthru('/usr/bin/python2.7 /home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py');
$output = ob_get_clean(); 
echo $output;*/

?>
</body>
</html>