<?php

function formatOutput($status, $data, $info){
	$output = array(
		"status" => $status,
		"data" => $data,
		"info" => $info
	);
	return $output;
}