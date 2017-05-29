<?php  
	define("DBHOST", "localhost");
	define("DBNAME", "ode_survey");
	define("DBUSER", "root");
	define("DBPASS", "Sep@2016");
	
	$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if($db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	}

	//pie1
	$sql = 'SELECT org_profile_category, count(*) as count
			from org_profiles where org_profile_category = "research" or org_profile_category = "submitted survey" 
			group by org_profile_category;';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	$data_pie1 = array();

	while($row = $result->fetch_assoc())
    {
        $data_pie1[] = $row;
    }

    //pie2
    $sql2 = 'SELECT org_profile_status, count(*) as count
			from org_profiles group by org_profile_status order by count desc;';
	if(!$result2 = $db->query($sql2)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	$data_pie2 = array();

	while($row2 = $result2->fetch_assoc())
    {
        $data_pie2[] = $row2;
    }

	//pie1
	$sql = 'SELECT org_profile_category, count(*) as count
			from org_profiles where org_profile_category = "research" or org_profile_category = "submitted survey" 
			group by org_profile_category;';

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	$data_pie1 = array();

	while($row = $result->fetch_assoc())
    {
        $data_pie1[] = $row;
    }

    //pie2
    $sql2 = 'SELECT org_profile_status, count(*) as count
			from org_profiles group by org_profile_status order by count desc;';
	if(!$result2 = $db->query($sql2)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	$data_pie2 = array();

	while($row2 = $result2->fetch_assoc())
    {
        $data_pie2[] = $row2;
    }

    //pie3
/*    $sql3 = 'SELECT CONCAT("Value") as value, CONCAT(YEAR(createdat),"-",LPAD(MONTH(createdat), 2, "0")) as cdate, COUNT(*) as count
FROM org_profiles
GROUP BY YEAR(createdat), MONTH(createdat) ORDER BY YEAR(createdat), MONTH(createdat);';*/

    $sql3 = 'SELECT CONCAT("Value") as value, CONCAT(YEAR(createdat),"-",LPAD(MONTH(createdat), 2, "0")) as cdate, COUNT(*) as count
			FROM org_profiles
			WHERE org_profile_status = "publish"
			GROUP BY YEAR(createdat), MONTH(createdat) ORDER BY YEAR(createdat), MONTH(createdat);';

	if(!$result3 = $db->query($sql3)){
	    die('There was an error running the query [' . $db->error . ']');
	}

	$data_pie3 = array();

	while($row3 = $result3->fetch_assoc())
    {
        $data_pie3[] = $row3;
    }



	//echo json_encode( $data_pie1, JSON_NUMERIC_CHECK );
	//echo "</br></br>";
	//echo json_encode( $data_pie2, JSON_NUMERIC_CHECK );
	//echo json_encode( $data_pie3, JSON_NUMERIC_CHECK );
?>

