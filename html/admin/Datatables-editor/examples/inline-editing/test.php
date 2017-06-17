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

$command = escapeshellcmd('/home/ubuntu/impact-map/scripts/agol-integration.py');
$output = shell_exec($command);
echo $output;

/*
$command = escapeshellcmd('../../../../../scripts/agol-integration/agol_integration.py');
$output = shell_exec($command);
echo $output;
*/

?>
</body>
</html>