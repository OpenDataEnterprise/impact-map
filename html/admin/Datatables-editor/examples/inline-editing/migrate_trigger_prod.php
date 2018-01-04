<?php
require_once "../../../../survey/credentials.inc.php";
ini_set("display_errors", "off");
require "../../../src/LS.php";

session_start();

if (!isset($_SESSION['login_true'])) {
    echo '<p class="login">Please <a href="../../../login.php">log in</a> to access this page.</p>';
    exit();
}

ini_set('display_errors', 1);
ini_set('output_buffering', 'off');
ini_set('zlib.output_compression', false);

while (@ob_end_flush());
ini_set('implicit_flush', true);
ob_implicit_flush(true);

echo str_pad("",1024," ");
echo "<br />";

putenv("AGOL_USER=" . AGOL_USER);
putenv("AGOL_PASS=" . AGOL_PASS);
putenv("AGOL_ENV=production");
shell_exec("export AGOL_USER");
shell_exec("export AGOL_PASS");
shell_exec("export AGOL_ENV");

$user = getenv('AGOL_USER');
$pass = getenv('AGOL_PASS');
$env = getenv('AGOL_ENV');

// On development, this shouldn't be running.
echo "Migrating to production is prohibited now...";
exit();

echo "Migrating... Wait for a minute until log messages show up below...<br><br>";
sleep(1);
flush();
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
        flush();
   }
   fclose($pipes[1]);

   $return_value = proc_close($proc);
}
//echo $output_text . "<br>";

// echo $output;
echo "<br><br>Done..";


?>
