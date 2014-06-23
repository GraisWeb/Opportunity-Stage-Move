<?php 

echo "Hello World! <br/><br/>"; 

// Connect to Infusionsoft

require_once __DIR__ . '../../lib/Infusionsoft/isdk.php';   
$app = new iSDK;
if ($app->cfgCon("hff89622")) {   // Make sure this matches your connection name in conn.cfg
	

// Current date in Infusionsoft-friendly format

	$currentDate = date_format(date_create(), 'Ymd\TH:i:s');
	echo "You connected at $currentDate <br/><br/>";
		
// Our recipe begins here

if ($_POST['Id']) {
		$contactId = $_POST['Id'];
	} else {
		$contactId = ($_POST['contactId']) ? $_POST['contactId'] : '';	
	}
		
	$newStageId = ($_POST['newStageId']) ? $_POST['newStageId'] : '';
	

		// Dump to file - Remove after testing is complete
					$file=fopen("kim_log.txt","a+");
					fwrite($file, "\n $currentDate \n");
					fwrite($file, print_r($_POST,true));
					fwrite($file, "\n Contact ID is $contactId \n");
					fwrite($file, "\n Stage ID is $newStageId \n");
					$file=fclose($file);





// API Call -> Query the lead table to find the opportunities for this contact
 
	$qryFields = array('Id', 'ContactID', 'StageID');
	$query = array('ContactID' => $contactId);
	$myOpp = $app->dsQuery("Lead",5,0,$query,$qryFields);
	 
	// Dump to file
					$file=fopen("kim_log.txt","a+");
					fwrite($file, "\n $currentDate \n");  
					fwrite($file, print_r($myOpp,true)); 
					$file=fclose($file);
	 

	
// Update the opportunity with the new stage
	 
	$update= array('StageID' => $newStageId);
	$oppID = $myOpp[0]['Id']; // This line assumes there is only one opp for this contact
	$opp = $app->dsUpdate("Lead", $oppID, $update);

	// Remove this when done testing
	echo "<br/>Updated Opp ID# ".$opp." <br/>";
	
	// Dump to file
					$toLog = "Updated Opp ID $opp";
					$file=fopen("kim_log.txt","a+");
					fwrite($file, "\n $toLog \n");  
					fwrite($file, " \n"); 
					$file=fclose($file);






	
} else {
	echo "Not Connected...";
} 


