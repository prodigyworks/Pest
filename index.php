<?php
	include("system-db.php");
	
	start_db();

	if (isMobileUserAgent()) {
		header("location: m.categories.php");
		
	} else {
		header("location: dashboard.php");
	}
?>
