<html>  
<head>

  <title> Edit Data Use</title>
  <link href="../../../../css/normalize.css" rel="stylesheet" type="text/css">
  <link href="../../../../css/webflow.css" rel="stylesheet" type="text/css">
  <link href="../../../../css/open-data-impact-map.webflow.css" rel="stylesheet" type="text/css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script type="text/javascript">
    WebFont.load({
      google: {
        families: ["Palanquin:100,200,300,regular,500,600,700"]
      }
    });
  </script>
  <script src="../../../../js/modernizr.js" type="text/javascript"></script>
  <link href="../../../../images/impactfaviconsmall.png" rel="shortcut icon" type="image/x-icon">
  <link href="../../../../impactfaviconlarge.png" rel="apple-touch-icon">
  <style>
    li { display: list-item; }
  </style>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-85257177-1', 'auto');
    ga('send', 'pageview');

</script>

</head>
<body>
<H1 style="text-align: center;">Edit Data Use</H1>
<style>
select, input{
margin-right: 2%;
margin-top: 1%;	
}

form{
	margin-left: 3%;
	margin-top: 2%;
}
</style>


<?php

define("DB_HOST", "localhost");
define("DB_NAME", "ode_survey");
define("DB_USER", "root");
define("DB_PASSWORD", "Sep@2016");
  
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_POST['submit'])) 
{	
	//$object_id = mysqli_real_escape_string($dbc, trim(isset($_POST['object_id'])));

	$counter = $_POST['count'];

//echo $counter;
	
$i =1;

while ( $i<= $counter)
{
	$object_id = $_POST['object_id'.$i];
	$data_type = $_POST['data_type'.$i];
	$data_use_type_other = $_POST['data_use_type_other'.$i];
	$data_src_gov_level = $_POST['data_src_gov_level'.$i];
	//$src_country_id = $_POST['src_country_id']; 
	$machine_read = $_POST['machine_read'.$i]; 

	$stud = explode("_",$_POST['org_hq_country'.$i]);
	$stud_id = $stud[0];
	$stud_name = $stud[1];

	$error_msg = 'False';

	if ($error_msg == 'False') 
	{
		$query_use = "UPDATE org_data_use SET DATA_TYPE = '$data_type', DATA_USE_TYPE_OTHER = '$data_use_type_other', DATA_SRC_GOV_LEVEL = '$data_src_gov_level', SRC_COUNTRY_ID = '$stud_id', MACHINE_READ = '$machine_read' WHERE OBJECT_ID = '$object_id'";

/*		echo 'object id '.$object_id;
		echo "</br>";
		echo $query_use;
		echo "</br>";*/

		$data_query_use = mysqli_query($dbc, $query_use);
/*		echo 'Data query use ' .$data_query_use;
		echo "</br>";*/
	if (!$data_query_use) {
      die ('Invalid Query: ' . mysql_error()) ;
    }
    else {
		//go back to dogs page if successful
    }
	}
$i++;
}
        echo '</br><H3 style = "text-align: center;">Data Use Updated</h3>';
}
else
{
?>
 <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

<?php
$id = intval($_GET['id']);
$orgname = $_GET['name'];

echo '<h3 style = "text-align: center;">Organization: '.$orgname.'</h3>';

$count = 1;
 $query = "select object_id, data_type, data_use_type_other, data_src_gov_level, src_country_id, machine_read from org_data_use where profile_id = $id";

 $data_query = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_assoc($data_query)) { 
            if ($row != NULL) {
		
                $object_id = $row['object_id'];

                echo '<input type="hidden" name="object_id'.$count.'" value='.$object_id.'>';

                $data_type = $row['data_type'];
                //echo 'Data type: <input type="text" name="data_type" value = '.$data_type. '></input><br/>';

                                // Build the query for director drop-down
$query1 = "SELECT DISTINCT data_type FROM org_data_use";
$result1 = @mysqli_query ($dbc, $query1);
echo 'Data type used: <select name = "data_type'.$count.'">';
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
echo '</select>';

                $data_use_type_other = $row['data_use_type_other'];
                echo 'Data type used - other: <input type="text" name="data_use_type_other'.$count.'" value = '.$data_use_type_other. '></input>';
                
                $data_src_gov_level = $row['data_src_gov_level'];
                //echo 'Data source government level: <input type="text" name="data_src_gov_level" value = '.$data_src_gov_level. '></input><br/>';
				$query2 = "SELECT DISTINCT data_src_gov_level FROM org_data_use";
				//$query2 = "SELECT DISTINCT data_src_gov_level FROM org_data_use WHERE data_src_gov_level <> ''";
$result2 = @mysqli_query ($dbc, $query2);
echo 'Data source - level: <select name = "data_src_gov_level'.$count.'">';
while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC))
{

	if ($row2['data_src_gov_level'] == $data_src_gov_level) 
	{
		echo '<option name="data_src_gov_level" value="'.$row2['data_src_gov_level'].'" selected="selected">' . 	$row2['data_src_gov_level'] . '</option>';
	}
	else 
	{	
		if ($row2['data_src_gov_level'] != '' ) //Added if loop Vinayak
		{
		echo '<option name="data_src_gov_level" value="'.$row2['data_src_gov_level'].'">' . $row2['data_src_gov_level'] . '</option>';			
		}

	}   
}
echo '</select>';


                $src_country_id = $row['src_country_id'];
   	            $query_country = "SELECT country_id, org_hq_country FROM org_country_info";
				$result_country = @mysqli_query ($dbc, $query_country);
echo 'Country: <select name = "org_hq_country'.$count.'">';
while ($row_country = mysqli_fetch_array($result_country, MYSQL_ASSOC))
{
	echo 'I am here!!';
	if ($row_country['country_id'] == $src_country_id) 
	{
		echo '<option name="org_hq_country" value="'.$row_country['country_id'].'_'.$row_country['org_hq_country'].'" selected="selected">' . 	$row_country['org_hq_country'] . '</option>';
	}
	else 
	{
		echo '<option name="org_hq_country" value="'.$row_country['country_id'].'_'.$row_country['org_hq_country'].'">' . 	$row_country['org_hq_country'] . '</option>';
	
	}   
}
echo '</select>';






                $machine_read = $row['machine_read'];
                //echo 'Machine Readable: <input type="text" name="machine_read" value = '.$machine_read. '></input><br/>';
                $query3 = "SELECT DISTINCT machine_read FROM org_data_use";
$result3 = @mysqli_query ($dbc, $query3);
echo 'Machine-readability: <select name = "machine_read'.$count.'">';
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
echo '</select>';



                echo "<br>";
            } else {
                echo '<p class="error">An error occured. Please try again later.</p>';
            }

   	            
            
        $count++;
        }

$count--;
?>


<input type="hidden" name="count" value="<?php echo $count; ?>">

<input style = "text-align: center;" type="submit" name="submit" value="Save Changes"></p>

</form>

<?php
}
?>
</body>
</html>