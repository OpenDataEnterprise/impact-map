<?php
// Introduce request / respond to socket
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Load Slim
require 'vendor/autoload.php';
// Load db handlers
require 'db.php';
// Load format function
require 'common.php';


// Instantiate Slim app
$app = new \Slim\App;

// // Slim hello world
// $app->get('/hello/{name}', function (Request $request, Response $response) {
//     $name = $request->getAttribute('name');
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });

// Define Slim router and respond to request
// Get all org names and profile ids
$app->get('/orgs', function($request, $response, $args){
	$db = new DBHandle();
	$orgs = $db->getOrgList();
	return $response->withJson(formatOutput(true, $orgs, 'Request Succeeded'));
});

// get full profile of one org
$app->get('/org/{id}', function($request, $response, $args){
	$id = $request->getAttribute('id');
	$db = new DBHandle();
	$org = $db->getOrg($id);
	return $response->withJson(formatOutput(true, $org, 'Request Succeeded'));
});

// get all org profiles
$app->get('/all', function($request, $response, $args){
	$db = new DBHandle();
	$all = $db->getAll();
	return $response->withJson(formatOutput(true, $all, 'Request Succeeded'));
});

// get total number of orgs in db
$app->get('/totalOrgNum', function($request, $response, $args){
	$db = new DBHandle();
	$num = $db->getTotalNumberOfOrgs();
	return $response->withJson(formatOutput(true, $num, 'Request Succeeded'));
});

// get total number of countries in db
$app->get('/totalCountryNum', function($request, $response, $args){
	$db = new DBHandle();
	$num = $db->getTotalNumberOfCountries();
	return $response->withJson(formatOutput(true, $num, 'Request Succeeded'));
});

// get total number of org in a region
$app->get('/orgNumInRegion/{region}', function($request, $response, $args){
	$region = $request->getAttribute('region');
	if ($region == "EAP") {$region = "East Asia & Pacific";}
		elseif ($region == "SAR") {$region = "South Asia";}
			elseif ($region == "ECA") {$region = "Europe & Central Asia";} 
				elseif ($region == "MENA") {$region = "Middle East & North Africa";} 
					elseif ($region == "LAC") {$region = "Latin America & Caribbean";} 
						elseif ($region == "SSA") {$region = "Sub-Saharan Africa";} 
							elseif ($region == "NA") {$region = "North America";}
	$db = new DBHandle();
	$num = $db->getNumberOfOrgsInRegion($region);
	return $response->withJson(formatOutput(true, $num, 'Request Succeeded'));
});

// get total number of orgs in a sector
$app->get('/orgNumInSector/{sector}', function($request, $response, $args){
	$sector = $request->getAttribute('sector');
	if ($sector == "AGR") {$sector = "Agriculture";}
		elseif ($sector == "ART") {$sector = "Arts, culture and tourism";}
			elseif ($sector == "BUS") {$sector = "Business, research and consulting";}
				elseif ($sector == "CONS") {$sector = "Consumer";}
					elseif ($sector == "EDU") {$sector = "Education";}
						elseif ($sector == "ENE") {$sector = "Energy and climate";}
							elseif ($sector == "FIN") {$sector = "Finance and insurance";}
								elseif ($sector == "GOV") {$sector = "Governance";}
									elseif ($sector == "HEA") {$sector = "Healthcare";}
										elseif ($sector == "HOU") {$sector = "Housing, construction & real estate";}
											elseif ($sector == "IT") {$sector = "IT and geospatial";}
												elseif ($sector == "MED") {$sector = "Media and communications";}
													elseif ($sector == "TRANS") {$sector = "Transportation and logistics";}
	$db = new DBHandle();
	$num = $db->getNumberOfOrgsInSector($sector);
	return $response->withJson(formatOutput(true, $num, 'Request Succeeded'));
});



$app->run();