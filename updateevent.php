<?php
	require_once("system-db.php");
	
	start_db();
	
	$id = $_POST['id'];
	$startdatetime = convertStringToDate($_POST['startdate']);
	$sectionid = $_POST['sectionid'];
	$mode = $_POST['mode'];
	
	if ($mode == "S") {
		$column = "memberid";

	} else if ($mode == "C") {
		$sql = "clientid";
	}

	$sql = "UPDATE {$_SESSION['DB_PREFIX']}diary SET 
			jobdate = '$startdatetime',
			$column = $sectionid
			WHERE id = $id";

	$result = mysql_query($sql);
	
	if (! $result) {
		logError($sql . " = " . mysql_error());
	}
		
	mysql_query("COMMIT");
?>
