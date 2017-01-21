<?php 
	require_once("system-db.php");
	
	function addRow($clientid, $date) {
		$sdate = $date->format("Y-m-d");
		$sql = "INSERT INTO {$_SESSION['DB_PREFIX']}diary
				(
					clientid, status, starttime
				)
				VALUES
				(
					$clientid, 'U', '$sdate'
				)";
		/* Add record from template */
		$insertresult = mysql_query($sql);

		if (! $insertresult) {
			logError(mysql_errno() . ": $sql - " . mysql_error());
		}
	}
	
	function addInitialContract($clientid) {
		$sql = "SELECT id, name, frequency, contracttype, startdate
				FROM {$_SESSION['DB_PREFIX']}client 
				WHERE id = $clientid";
		$result = mysql_query($sql);
		
		//Check whether the query was successful or not
		if($result) {
			while (($member = mysql_fetch_assoc($result))) {
				$clientname = $member['name'];
				$frequency = $member['frequency'];
				$contracttype = $member['contracttype'];
				$startofcontract = $member['startdate'];
				$date = $startofcontract;
				$days = floor(365 / $frequency);
				
				echo "<p>$clientname</p>";
				
				for ($year = 0; $year < 20; $year++) {
					$date = DateTime::createFromFormat('Y-m-d', $startofcontract);
					$date->modify("+$year years");
					
//					echo "<p>$clientname</p>";
					
					for ($i = 0; $i < $frequency; $i++) {
//						echo "$i. Client ID:$clientid - Freq:$frequency - Diff $diff - Days: $days - Start:$sdate - Add:$add - Start:$startofyear - End:$endofyear<br>";

						if ($contracttype == "A") {
							/* Add row. */
							addRow($clientid, $date);
							
							if ($frequency == 104) {
								/* Twice Weekly */
								if (($i % 2) == 0) {
									$date->modify("+3 days");
									
								} else {
									$date->modify("+4 days");
								}
								
							} else if ($frequency == 52) {
								/* Weekly */
								$date->modify("+7 days");
								
							} else if ($frequency == 26) {
								/* Bi Weekly */
								$date->modify("+14 days");
								
							} else if ($frequency == 12) {
								/* Monthly */
								$date->modify("+1 month");
								
							} else if ($frequency == 6) {
								/* Bi Monthly */
								$date->modify("+2 month");
								
							} else if ($frequency == 4) {
								/* Tri Monthly */
								$date->modify("+3 month");
								
							} else if ($frequency == 3) {
								/* Quarterly */
								$date->modify("+4 month");
								
							} else if ($frequency == 2) {
								/* 6 month */
								$date->modify("+6 month");
								
							} else {
								/* Calculation. */
								$date->modify("+$days days");
							}

						} else if ($contracttype == "B") {
							if ($date->format('m') >= 5 && $date->format('m') <= 8) {
								/* Add row. */
								addRow($clientid, $date);
							}
							
							$date->modify("+1 month");

						} else if ($contracttype == "C") {
							/* Add row. */
							addRow($clientid, $date);
								
							if ($date->format('m') >= 5 && $date->format('m') <= 8) {
								$date->modify("+14 days");
								
							} else {
								$date->modify("+7 days");
							}
						}
					}
				}
			}
					
		} else {
			logError($sql . " - " . mysql_error());
		}
	}
?>