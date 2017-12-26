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
//passthru("agol-integration/agol_integration.py", $output_text);

$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
   2 => array("file", "/var/log/odesurvey/error-migration.txt", "a") // stderr is a file to write to
);

$proc = proc_open("python agol-integration/agol_integration.py", $descriptorspec, $pipes);

if (is_resource($proc)) {
   fclose($pipes[0]);

   $pos = FALSE;   
   while ($pos === FALSE) {
	
        $out = fgets($pipes[1], 300);
	echo $out . "<br>\n";
	$pos = strpos($out, "Number of features written to AGOL");
	sleep(1);
   }
   fclose($pipes[1]);

   $return_value = proc_close($proc);
}
//echo $output_text . "<br>";

// echo $output;
echo "<br><br>Done..";


?>
</body>
</html>
