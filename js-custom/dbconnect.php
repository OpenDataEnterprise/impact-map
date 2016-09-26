<?php
$host = 'localhost:3306';
$username = 'root';
$password = 'Sep@2016';
$database = 'opendata_db';

    $server = mysql_connect($host, $username, $password);
    $connection = mysql_select_db($database, $server);

    $mapreg = $mapreg;

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

$myquery = "select final.iso2, final.org_hq_country, count(final.org_name) as `orgcount`
from (select distinct a.country_id, a.org_hq_country, a.iso2, c.org_name from `org_country_info` as a 
left outer join `org_locations_info` as b 
on a.country_id = b.country_id 
left outer join `org_profiles` as c
on b.object_id = c.org_loc_id where a.org_hq_country_region = '$mapreg') final 
group by (final.org_hq_country)";

    $query = mysql_query($myquery);


    if ( ! $query ) {
        echo mysql_error();
        die;
    }
    
    $data = array();

    while($row =mysql_fetch_assoc($query))
    {
        $data[] = $row;
    }
 
 $count = mysql_num_rows($query);

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
     

    mysql_close($server);
?>
