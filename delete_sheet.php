<?php

include 'excel/Classes/PHPExcel/IOFactory.php';
$inputFileName = 'deletes.xls';

$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

/*Need to remove the header row from ILLiad sheet*/

$objPHPExcel->getActiveSheet()->removeRow(1,1);

$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$count = 0;
   
echo "<!DOCTYPE html>\n<html><body>";

echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the spreadsheet format.';

echo '<br><br>';

echo '<h2>Delete patron report:</h2><br>';

foreach ($sheetData as $row) {

   	$count = $count + 1;
   	$fulluid = $row['A'];
	$ch = curl_init();
	$url = 'https://api-na.hosted.exlibrisgroup.com/almaws/v1/users/{user_id}';
	$templateParamNames = array('{user_id}');
	$templateParamValues = array(urlencode($fulluid));
	$url = str_replace($templateParamNames, $templateParamValues, $url);
	$queryParams = '?' . urlencode('user_id_type') . '=' . urlencode('all_unique') . '&' . urlencode('apikey') . '=' . urlencode('YOUR ALMA API KEY');
	curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	$response = curl_exec($ch);
		
	if (empty($response)) {
   
  		echo "UserID " . $fulluid . " HAS been deleted" . '<br />';       
  	}
  	else {
		echo "\nUserID " .$fulluid . " Could not be deleted because " . $response . '<br />';
  	}
	
	curl_close($ch);
}
echo '<br><br>';
print $count . "  Patrons records handled.\n\n";
echo "\n</body></html>";

?>
