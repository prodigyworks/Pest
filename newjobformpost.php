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
	$jobreadytobeinvoiced = isset($_POST['jobreadytobeinvoiced']) ? "Y" : "N";
	$jobautoallocate = isset($_POST['jobautoallocate']) ? "Y" : "N";
	
	if ($jobautoallocate == "Y") {
		$memberid = getLoggedOnMemberID();
	
		$sql = "INSERT INTO {$_SESSION['DB_PREFIX']}diary
				(
					clientid, starttime, jobtime, status,
					jobobservations, jobvisittype, jobaddress,
					jobreadytobeinvoiced, memberid, allocateddate
				)
				VALUES
				(
					$clientid, '$jobdate', '$jobtime', 'A',
					'$jobobservations', '$jobvisittype', '$jobaddress',
					'$jobreadytobeinvoiced', $memberid, CURDATE()
				)";

	} else {
		$sql = "INSERT INTO {$_SESSION['DB_PREFIX']}diary
				(
					clientid, starttime, jobtime, status,
					jobobservations, jobvisittype, jobaddress,
					jobreadytobeinvoiced
				)
				VALUES
				(
					$clientid, '$jobdate', '$jobtime', 'N',
					'$jobobservations', '$jobvisittype', '$jobaddress',
					'$jobreadytobeinvoiced'
				)";
	}
	
	$result = mysql_query($sql);
	
	$id = mysql_insert_id();
	
	if (! $result) {
		logError(mysql_errno() . ": $sql - " . mysql_error());
	}
	
	mysql_query("COMMIT");
	
	if ($jobautoallocate == "N") {
		header("location: jobformconfirm.php");
		
	} else {
		header("location: jobform.php?id=$id");
	}
	
?>