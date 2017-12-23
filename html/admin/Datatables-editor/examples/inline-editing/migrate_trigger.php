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


putenv("AGOL_USER=" . AGOL_USER);
putenv("AGOL_PASS=" . AGOL_PASS);
putenv("AGOL_ENV=" . AGOL_ENV);
shell_exec("export AGOL_USER");
shell_exec("export AGOL_PASS");
shell_exec("export AGOL_ENV");

$user = getenv('AGOL_USER');
$pass = getenv('AGOL_PASS');
$env = getenv('AGOL_ENV');

//echo exec('sudo python /home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py');

// $output = shell_exec("/home/ubuntu/impact-map/scripts/agol-integration/agol-integration.py");
//$output = shell_exec("/var/scripts/agol-integration/agol_integration.py");
echo "Migrating... <br><br>";
// $output = exec("agol-integration/agol_integration.py");
echo passthru("agol-integration/agol_integration.py");
// echo $output;
echo "<br><br>Done..";


?>
</body>
</html>
