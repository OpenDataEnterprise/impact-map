<?php




//cred test for db
function connect_db() {
	//shell_exec(“ssh -f -L 3307:127.0.0.1:3306 vagrant@127.0.0.1:2322 sleep 60 >> logfile”);  
    //$db = mysqli_connect(’127.0.0.1', ‘sqluser’, ‘sqlpassword’, ‘rjmadmin’, 3306);
	$dbhost="127.0.0.1";
	$dbuser="root";
	$dbpass="Sep@2015";
	$dbname="opendata_db";
	try
	{
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected successfully";
	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}
	return $dbh;
}

?>