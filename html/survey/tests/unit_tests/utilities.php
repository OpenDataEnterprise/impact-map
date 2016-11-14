<?php


/** 
 * Send a GET requst using cURL 
 * @param string $url to request 
 * @param array $get values to send 
 * @param array $options for cURL 
 * @return string 
 * @source from PHP Manual pages
 */ 

function UtilCurlGet($url, array $get = array(), array $options = array()) 
{    
    $defaults = array( 
    	CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '' : '?'). http_build_query($get),
   		CURLOPT_HEADER => 0, 
     	CURLOPT_SSL_VERIFYPEER => FALSE,
    	CURLOPT_SSL_VERIFYHOST => FALSE,
    	CURLOPT_RETURNTRANSFER => TRUE, 
    	CURLOPT_TIMEOUT => 120
    ); 
    // echo "defaults: ".$defaults[CURLOPT_URL];

    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 
    
    if( ! $result = curl_exec($ch)) 
    { 
      trigger_error(curl_error($ch)); 
      echo "<br>here error";
      echo curl_error($ch);
    }
    curl_close($ch);
    return $result; 
}

/** 
 * Send a POST requst using cURL 
 * @param string $url to request 
 * @param array $post values to send 
 * @param array $options for cURL 
 * @return string 
 * @source from PHP Manual pages
 */ 
function UtilCurlPost($url, array $post = NULL, array $header = NULL, array $options = array()) 
{  
    
	echo "preparing to post\n";

	$defaults = array( 
    	CURLOPT_POST => 1, 
    	CURLOPT_HEADER => $header, 
    	CURLOPT_URL => $url, 
    	CURLOPT_FRESH_CONNECT => 1, 
    	CURLOPT_SSL_VERIFYPEER => FALSE,
    	CURLOPT_SSL_VERIFYHOST => FALSE,
    	CURLOPT_RETURNTRANSFER => 1, 
    	CURLOPT_FORBID_REUSE => 1, 
    	CURLOPT_TIMEOUT => 1200, 
    	CURLOPT_POSTFIELDS => $post_fields
    ); 
	
	echo "<pre>\n";print_r($defaults);echo "</pre>\n";

    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 

    echo "about to run curl_exec";

    if( ! $result = curl_exec($ch)) 
    { 
    	trigger_error(curl_error($ch)); 
    } 
    curl_close($ch); 
    	return $result; 
 } 

 ?>