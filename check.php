<?php

	require_once('includes/functions.php');
	require_once("includes/keys.php");
	
	$un = $DB_ID;
	$pw = $DB_KEY;

	$db = "texts";
	$col = "messages";	
	
	$collection = mongoCollection( $un, $pw, $db, $col );

////////////////////////////////////////////////////////////////////
//-------------------- CHECK FOR A MESSAGE -----------------------//
////////////////////////////////////////////////////////////////////

	
	if( isset($_GET['phrase']) ){
	
		//id of the group ALGO
		//might change this to pass group name via oF
		//search joins DB get ID search messages DB -
		//is that worth it? Two db calls for every message check?
		
		$id = new MongoId('4ee769d6d1c3cd407a130420');
		
		$object = array(
							"group_id" =>  $id,
							'$where' => "this.delivered<1"
		);
		
		$sort = array("timestamp"=>1 );
		$cursor = $collection->find($object)->sort($sort)->limit(1);
		$c = iterator_count($cursor);
		
		if($c < 1){
			echo "no";
		}else{
			foreach($cursor as $c){	
				$string = trim($c["_id"]).'|'.trim($c["message"]).'|'.trim($c["visual"]);
				echo $string;
			}
		}
	
////////////////////////////////////////////////////////////////////
//------------------ MARK RECIEVED MESSAGE -----------------------//
////////////////////////////////////////////////////////////////////
	
	} elseif( isset($_GET['id']) || isset($_POST['id']) ){
	
		if( isset($_GET['id']) ) $id = $_GET['id'];
		else $id = $_POST['id'];
		
		$mid = new MongoId($id);
		$_id = array("_id"=> $mid);
		
		$delivered = array( '$inc' => array( "delivered" => 1 ) );
		$upsert = array('upsert' => true);
		
		try{
			$collection->update($_id, $delivered, $upsert);
			echo "DELIVERY_SUCCESS";
		} catch(Exception $e){
			echo 'Caught exception:', $e->getMessage(), "\n";
		}
		
	}  
	
?>


