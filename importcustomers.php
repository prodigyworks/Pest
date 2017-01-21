<?php
	include("system-header.php"); 
	include("diaryfunctions.php"); 
	
	$substringstart = 0;
	
	set_time_limit(0);
	
	function startsWith($Haystack, $Needle){
	    // Recommended version, using strpos
	    return strpos($Haystack, $Needle) === 0;
	}


	if (isset($_FILES['customerfile']) && $_FILES['customerfile']['tmp_name'] != "") {
		if ($_FILES["customerfile"]["error"] > 0) {
			echo "Error: " . $_FILES["customerfile"]["error"] . "<br />";
			
		} else {
		  	echo "Upload: " . $_FILES["customerfile"]["name"] . "<br />";
		  	echo "Type: " . $_FILES["customerfile"]["type"] . "<br />";
		  	echo "Size: " . ($_FILES["customerfile"]["size"] / 1024) . " Kb<br />";
		  	echo "Stored in: " . $_FILES["customerfile"]["tmp_name"] . "<br>";
		}
		
		$subcat1 = "";
		$row = 1;
		
		if (($handle = fopen($_FILES['customerfile']['tmp_name'], "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        if ($row++ == 1) {
		        	continue;
		        }
		        
		        $num = count($data);
		        $index = 0;
		        
		        $siteid = mysql_escape_string($data[$index++]);
		        $company = mysql_escape_string($data[$index++]);
		        $address1 = mysql_escape_string($data[$index++]);
		        $address2 = mysql_escape_string($data[$index++]);
		        $address3 = mysql_escape_string($data[$index++]);
		        $address4 = mysql_escape_string($data[$index++]);
		        $city = mysql_escape_string($data[$index++]);
		        $county = mysql_escape_string($data[$index++]);
		        $postcode = mysql_escape_string($data[$index++]);
		        $email = mysql_escape_string($data[$index++]);
		        $phone = mysql_escape_string($data[17]);
		        $frequency = convertStringToDate($data[26]);
		        $startdate = convertStringToDate($data[27]);
		        $type = mysql_escape_string($data[28]);
		        
		        $phone = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $phone);
		        $email = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $email);
		        
		        if ($frequency == "") {
		        	$frequency = "0";
		        }
		        
		        $address = $address1;
		        
		        if ($address2 != "") $address .= "\n$address2";
		        if ($address3 != "") $address .= "\n$address3";
		        if ($address4 != "") $address .= "\n$address4";
		        if ($city != "") $address .= "\n$city";
		        if ($county != "") $address .= "\n$county";
		        if ($postcode != "") $address .= "\n$postcode";
		        
		        if ($data[0] != "") {
		        	echo "<div>Product: $productcode</div>";
		        	
					$qry = "INSERT INTO {$_SESSION['DB_PREFIX']}client 
							(
								name, status, address, email, telephone, 
								frequency, startdate, contracttype,
								metacreateduserid, metamodifieduserid,
								metacreateddate, metamodifieddate
							)  
							VALUES  
							(
								'$company', 'L', '$address', '$email', '$phone', 
								$frequency, '$startdate', '$type',
								1, 1,
								NOW(), NOW()
							)";
							
					$result = mysql_query($qry);
        	
					if (mysql_errno() != 0) {
						if (mysql_errno() != 1062) {
							logError(mysql_error() . " : " .  $qry);
						}
						
					} else {
						addInitialContract(mysql_insert_id());
					}
					
		        }
		    }
		    
		    fclose($handle);
			echo "<h1>" . $row . " downloaded</h1>";
		}
	}
	
	if (! isset($_FILES['customerfile'])) {
?>	
		
<form class="contentform" method="post" enctype="multipart/form-data">
	<label>Upload customer CSV file </label>
	<input type="file" name="customerfile" id="customerfile" /> 
	
	<br />
	 	
	<div id="submit" class="show">
		<input type="submit" value="Upload" />
	</div>
</form>
<?php
	}
	
	include("system-footer.php"); 
?>