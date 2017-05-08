<html>  
<head>

  <title> NESR Edit Contact Information</title>

</head>
<body>

<?php

define("DB_HOST", "localhost");
define("DB_NAME", "ode_survey");
define("DB_USER", "root");
define("DB_PASSWORD", "Sep@2016");
  
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_POST['submit'])) 
{	
	//$object_id = mysqli_real_escape_string($dbc, trim(isset($_POST['object_id'])));

	$object_id = $_POST['object_id'];
	
	$data_type = $_POST['data_type'];
	$data_use_type_other = $_POST['data_use_type_other'];
	$data_src_gov_level = $_POST['data_src_gov_level'];
	//$src_country_id = $_POST['src_country_id']; 
	$machine_read = $_POST['machine_read']; 

	$error_msg = 'False';

	if ($error_msg == 'False') 
	{
		$query_use = "UPDATE ORG_DATA_USE SET DATA_TYPE = '$data_type', DATA_USE_TYPE_OTHER = '$data_use_type_other', DATA_SRC_GOV_LEVEL = '$data_src_gov_level', MACHINE_READ = '$machine_read' WHERE OBJECT_ID = '$object_id'";

		echo $query_use;
		$data_query_use = mysqli_query($dbc, $query_use);

	if (!$data_query_use) {
      die ('Invalid Query: ' . mysql_error()) ;
    }
    else {
		//go back to dogs page if successful
        echo "Data Use Updated";
    }
	}
}
else
{
?>
 <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

<?php
$id = intval($_GET['id']);
$count = 1;
 $query = "select object_id, data_type, data_use_type_other, data_src_gov_level, src_country_id, machine_read from org_data_use where profile_id = $id";

 $data_query = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_assoc($data_query)) { 
            if ($row != NULL) {
		
                $object_id = $row['object_id'];
                $data_type = $row['data_type'];
                //echo 'Data type: <input type="text" name="data_type" value = '.$data_type. '></input><br/>';

                                // Build the query for director drop-down
$query1 = "SELECT DISTINCT data_type FROM org_data_use";
$result1 = @mysqli_query ($dbc, $query1);
echo 'Data Type: <select name = "data_type">';
while ($row1 = mysqli_fetch_array($result1, MYSQL_ASSOC))
{

	if ($row1['data_type'] == $data_type) 
	{
		echo '<option name="data_type" value="'.$row1['data_type'].'" selected="selected">' . 	$row1['data_type'] . '</option>';
	}
	else 
	{
		echo '<option name="data_type" value="'.$row1['data_type'].'">' . 	$row1['data_type'] . '</option>';
	}   
}
echo '</select> </p>';

                $data_use_type_other = $row['data_use_type_other'];
                echo 'Data use type other: <input type="text" name="data_use_type_other" value = '.$data_use_type_other. '></input></p>';
                
                $data_src_gov_level = $row['data_src_gov_level'];
                //echo 'Data source government level: <input type="text" name="data_src_gov_level" value = '.$data_src_gov_level. '></input><br/>';
				$query2 = "SELECT DISTINCT data_src_gov_level FROM org_data_use";
$result2 = @mysqli_query ($dbc, $query2);
echo ' data_src_gov_level: <select name = "data_src_gov_level">';
while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC))
{
	if ($row2['data_src_gov_level'] == $data_src_gov_level) 
	{
		echo '<option name="data_src_gov_level" value="'.$row2['data_src_gov_level'].'" selected="selected">' . 	$row2['data_src_gov_level'] . '</option>';
	}
	else 
	{
		echo '<option name="data_src_gov_level" value="'.$row2['data_src_gov_level'].'">' . 	$row2['data_src_gov_level'] . '</option>';
	}   
}
echo '</select> </br>';

                $src_country_id = $row['src_country_id'];
                $country = mysqli_fetch_assoc(mysqli_query($dbc, "select org_hq_country from org_country_info where country_id = $src_country_id"));
				$org_hq_country = $country['org_hq_country'];
   	            echo 'Country: <input type="text" name="org_hq_country" value = '.$org_hq_country. '></input><br/>';

                $machine_read = $row['machine_read'];
                //echo 'Machine Readable: <input type="text" name="machine_read" value = '.$machine_read. '></input><br/>';
                $query3 = "SELECT DISTINCT machine_read FROM org_data_use";
$result3 = @mysqli_query ($dbc, $query3);
echo ' machine_read: <select name = "machine_read">';
while ($row3 = mysqli_fetch_array($result3, MYSQL_ASSOC))
{
	if ($row3['machine_read'] == $machine_read) 
	{
		echo '<option name="machine_read" value="'.$row3['machine_read'].'" selected="selected">' . 	$row3['machine_read'] . '</option>';
	}
	else 
	{
		echo '<option name="machine_read" value="'.$row3['machine_read'].'">' . 	$row3['machine_read'] . '</option>';
	}   
}
echo '</select> </br>';



                echo "<br>";
            } else {
                echo '<p class="error">An error occured. Please try again later.</p>';
            }
        }

?>

      <input type="hidden" name="object_id" value="<?php echo $object_id; ?>">
      
 <p><input type="submit" name="submit" value="Save Changes"></p>
</form>

<?php
}
?>
</body>
</html>