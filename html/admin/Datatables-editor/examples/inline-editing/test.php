<html>  
<head>

  <title> Edit Data Use</title>

</head>
<body>
<H1 style="text-align: center;">Test Page</H1>

<?php

$AGOLUSER = 'gregelin2';
$AGOLPASS ='orange-x39';
$AGOLENV = 'development';

putenv("AGOL_USER=$AGOLUSER");
putenv("AGOL_PASS=$AGOLPASS");
putenv("AGOL_ENV=$AGOLENV");

$user = getenv('AGOL_USER');
$pass = getenv('AGOL_PASS');
$env = getenv('AGOL_ENV');

echo "</br>AGOL_USER " . $user;
echo "</br>AGOL_PASS " . $pass;
echo "</br>AGOL_ENV " . $env. "</br>";

/*echo exec('whoami');

echo exec('/home/ubuntu/impact-map/scripts/agol-integration.py');
*/

shell_exec("/home/ubuntu/impact-map/scripts/agol-integration.py");


echo exec('/home/ubuntu/impact-map/scripts/agol-integration.py');

$command = escapeshellcmd('/home/ubuntu/impact-map/scripts/agol-integration.py');
$output = shell_exec($command);
echo $output;

ob_start();
passthru('/usr/bin/python2.7 /home/ubuntu/impact-map/scripts/agol-integration.py');
$output = ob_get_clean(); 
echo $output;


?>
</body>
</html>