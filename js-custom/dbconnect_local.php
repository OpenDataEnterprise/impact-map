<?php
$host = 'localhost:8889';
$username = 'root';
$password = '19880518';
$database = 'opendata_db';

   $db = new mysqli($host, $username, $password, $database);

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $mapreg = $mapreg;
    // $mapreg = "Europe & Central Asia";

/*$myquery = "SELECT  `lat`, `lng`, `l_count` FROM  `locations` WHERE `lat` <> 0";  
*/
/*$myquery = "SELECT  * FROM  `org_country_info` as a where `country_id` = 65"; */ 

/*$myquery = "select final.iso2, final.org_hq_country, count(final.org_name) as `orgcount`
from (select distinct a.country_id, a.org_hq_country, a.iso2, c.org_name from `org_country_info` as a 
left outer join `org_locations_info` as b 
on a.country_id = b.country_id 
left outer join `org_profiles` as c
on b.object_id = c.org_loc_id where a.org_hq_country_region = 'Europe & Central Asia') final 
group by (final.org_hq_country)";
*/

$myquery = "SELECT final.iso2, final.org_hq_country, count(final.org_name) as `orgcount`
from (select distinct a.country_id, a.org_hq_country, a.iso2, c.org_name from `org_country_info` as a 
left outer join `org_locations_info` as b 
on a.country_id = b.country_id 
left outer join `org_profiles` as c
on b.object_id = c.org_loc_id where a.org_hq_country_region = '$mapreg') final 
group by (final.org_hq_country)";

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

/* echo "var testdata = [";
    
    for ($x = 0; $x < mysql_num_rows($query); $x++) {
        $data[] = mysql_fetch_assoc($query);
        echo "[",$data[$x]['lat'],",",$data[$x]['lng'],"]";
        if ($x <= (mysql_num_rows($query)-2) ) {
      echo ",";
    }
    }
`
      echo "];";*/
    
?>
