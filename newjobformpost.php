<?php 
	require_once("system-db.php"); 
	require_once("sqlfunctions.php"); 
	
	start_db();
	
	$jobdate = $_POST['jobdate'];
	$jobtime = mysql_escape_string($_POST['jobtime']);
	$jobaddress = mysql_escape_string($_POST['jobaddress']);
	$jobvisittype = mysql_escape_string($_POST['jobvisittype']);
	$clientid = mysql_escape_string($_POST['siteid']);
	$jobobservations = mysql_escape_string($_POST['jobobservations']);
	
	$sql = "INSERT INTO {$_SESSION['DB_PREFIX']}diary
			(
				clientid, starttime, jobtime, status,
				jobobservations, jobvisittype, jobaddress
			)
			VALUES
			(
				$clientid, '$jobdate', '$jobtime', 'N',
				'$jobobservations', '$jobvisittype', '$jobaddress'
			)";
	
	$result = mysql_query($sql);
	
	if (! $result) {
		logError(mysql_errno() . ": $sql - " . mysql_error());
	}
	
	mysql_query("COMMIT");
	
	header("location: jobformconfirm.php");
?>