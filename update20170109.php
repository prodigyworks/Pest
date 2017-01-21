<?php
	require_once("system-db.php");
	
	start_db();

	$sql = "SELECT id, client, starttime, status FROM pest_diary ORDER BY starttime, status";
	
	$result = mysql_query($sql);
	$array = array();
	
	while (($member = mysql_fetch_assoc($result))) {
		if ($member['status'] == "C") {
			
		}
	}
	
	mysql_query("COMMIT");
	
	function runsql($sql) {
		echo str_replace("\n", "<br>", $sql);
			
		$result = mysql_query($sql);
		
		if (! $result) {
			logError(mysql_error());
		}
	}
?>
