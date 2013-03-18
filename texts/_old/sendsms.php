<!DOCTYPE html>
<?php
 	
 	if( isset($_GET['Message']) && isset($_GET['To']) ):
 			echo $_GET['Message'];
 		 	$user = $_GET['To'];
 			$message = $_GET['Message'];
 			$valid = true;
 			
 			//echo 'junk';
 			
 	else:
 	
 		    $valid = false;
 		   //echo 'oops';
 	
 	endif;
 	
    require "includes/functions.php";

    // set our AccountSid and AuthToken
    $AccountSid = $TWIL_SID;
    $AuthToken = $TWIL_KEY;
    
    // instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);
 
    // make an associative array 
    // indexed by number
    if($valid === true):
	
		echo '<br>sending<br>'.$user;
	
	$sms = $client->account->sms_messages->create(
		$TWIL_NUMBER,
		$user,
		$message
	);
	
	echo "Message sent!";
	

		
 	else:
 	
 		echo "did not send";
 	
    endif;
?>