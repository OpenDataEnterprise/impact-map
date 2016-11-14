<?php
    require 'credentials.test.php';
	include './PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';

$inputFileName = './insert_excel.xlsx';

//  Read your Excel workbook for country table information
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
echo $highestRow;
$highestColumn = $sheet->getHighestColumn();
echo $highestColumn;

$db=connect_db();
$countryInfoQuery = "INSERT INTO
     		org_country_info(
	 		`org_hq_country`,`org_hq_country_income`,`org_hq_country_income_code`,`org_hq_country_locode`,`org_hq_country_region`,`org_hq_country_region_code`
			)VALUES (:org_hq_country,
			:org_hq_country_income,
			:org_hq_country_income_code,
			:org_hq_country_locode,
			:org_hq_country_region,
			:org_hq_country_region_code
			)";
			$stmt = $db->prepare($countryInfoQuery);
    //  Read a row of data into an array
for($row=2; $row<=$highestRow;$row++)
    {
			
    		$row_val= $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
			$org_hq_country = $row_val[0][0];
			$org_hq_country_locode =$row_val[0][1];
			$org_hq_country_region = $row_val[0][2];
			$org_hq_country_region_code =$row_val[0][3];
			$org_hq_country_income = $row_val[0][4];
			$org_hq_country_income_code = $row_val[0][5];
			
        
        $stmt->bindParam("org_hq_country", $org_hq_country);
		$stmt->bindParam("org_hq_country_income", $org_hq_country_income);
		$stmt->bindParam("org_hq_country_income_code", $org_hq_country_income_code);
		$stmt->bindParam("org_hq_country_locode", $org_hq_country_locode);
		$stmt->bindParam("org_hq_country_region", $org_hq_country_region);
		$stmt->bindParam("org_hq_country_region_code", $org_hq_country_region_code);
        $stmt->execute();
    	$lastCountryId=$db->lastInsertId();
		echo $row;
   //echo $user;
        /*$last_id = mysql_insert_id();*/
    //$db = null;
      //echo json_encode($user); 
    	
  
    //  Insert row data array into your database of choice here
}
?>