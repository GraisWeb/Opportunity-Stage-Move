<?php 

echo "Hello World! <br/><br/>"; 

// Connect to Infusionsoft

require_once __DIR__ . '../../lib/Infusionsoft/isdk.php';   
$app = new iSDK;
if ($app->cfgCon("hff89622")) {   // Make sure this matches your connection name in conn.cfg.php

// Recipe starts here
	
	// Current date in Infusionsoft-friendly format

	$currentDate = date_format(date_create(), 'Ymd\TH:i:s');
	echo "You connected at $currentDate <br/><br/>";
	
	$contactId = 18853;    // Dritte Dawg
	$newStageId    = 35;    // Change this StageID to whatever you want it to change it to
	 
	// API Call -> Query the lead table to find the opportunities for this contact
 
	$qryFields = array('Id', 'ContactID', 'StageID');
	$query = array('ContactID' => $contactId);
	$myOpp = $app->dsQuery("Lead",5,0,$query,$qryFields);
	 
	 //Remove these three lines when done testing
	 echo "<pre>";
	 print_r($myOpp);
	 echo "</pre>";
	 
	


// Update the opportunity with the new stage
	 
	$update= array('StageID' => $newStageId);
	$oppID = $myOpp[0]['Id']; // This line assumes there is only one opp fpr this contact
	$opp = $app->dsUpdate("Lead", $oppID, $update);

	// Remove this line when done testing
	echo "<br/>Updated Opp ID# ".$opp." <br/>";






	
} else {
	echo "Not Connected...";
} 


