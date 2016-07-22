<?php
	require_once("system-db.php");
	require_once("reportjoblib.php");
	
	start_db();
	
	$pdf = new JobReport( 'P', 'mm', 'A4', $_GET['id']);
	$pdf->Output();
?>