<?php 
	require_once("system-db.php");
	require_once("diaryfunctions.php");
	
	start_db();
	
	$sql = "SELECT id, name, frequency, contracttype, startdate
			FROM {$_SESSION['DB_PREFIX']}client 
			WHERE status = 'L' 
			ORDER BY name DESC";
	$result = mysql_query($sql);
	
	//Check whether the query was successful or not
	if($result) {
		while (($member = mysql_fetch_assoc($result))) {
			$clientid = $member['id'];
			
			addInitialContract($clientid);
		}
				
	} else {
		logError($sql . " - " . mysql_error());
	}

	mysql_query("COMMIT");
?>