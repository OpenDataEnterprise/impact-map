latitude,longitude,org_name,org_type,org_year_founded
<?php
    foreach ($org_profiles as $org_profile) {
        // echo "<pre>"; print_r($org_profile); echo "..".$org_profile['org_name']."</pre>";
        if ( array_key_exists('org_name', $org_profile) ) { 
        // if ( array_key_exists('org_name', $org_profile) && $org_profile['org_profile_status'] == 'submitted') { 
            // echo $org_profile['objectId'].",";
            // echo $org_profile['org_name'].",";
            // echo $org_profile['org_type'].",";
echo "${org_profile['latitude']},${org_profile['longitude']},${org_profile['org_name']},${org_profile['org_type']},${org_profile['org_year_founded']}";
            // echo "<td><a href='/survey/opendata/".$org_profile['objectId']."/submitted'>".$org_profile['objectId']."</a></td>";
            echo "\n";
        }
    }
?>