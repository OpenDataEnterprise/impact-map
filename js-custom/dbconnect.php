<?php
    include("db_config.php");

    $db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $mapreg = $mapreg;

    $myquery = "SELECT final.iso2, final.org_hq_country, count(final.org_name) as `orgcount` 
            from (select distinct a.country_id, a.org_hq_country, a.iso2, c.org_name from org_country_info as a 
            left outer join org_locations as b 
            on a.country_id = b.country_id 
            left outer join org_profiles as c 
            on b.location_id = c.location_id 
            where a.org_hq_country_region = '$mapreg') final 
            group by (final.org_hq_country);";

    if(!$result = $db->query($myquery)){
        die('There was an error running the query [' . $db->error . ']');
    }
    
    $data = array();

    while($row = $result->fetch_assoc())
    {
        $data[] = $row;
    }
 
    $count = mysqli_num_rows($result);

    echo json_encode($data);
?>
