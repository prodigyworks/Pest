<?php
	require_once('system-db.php');
	require_once('pdfreport.php');
	require_once("simple_html_dom.php");
	
	class ReadyToBeInvoicedReport extends PDFReport {
		
		function AddPage($orientation='', $size='') {
			parent::AddPage($orientation, $size);
			
			$this->Image("images/logomain2.png", 148.6, 1);
			
			$size = $this->addText( 10, 13, "Ready To Be Invoiced", 12, 4, 'B') + 5;
			$this->SetFont('Arial','', 8);
				
			$cols = array( 
					"Client"  => 85,
					"Job ID"  => 25,
					"Type"  => 35,
					"Date"  => 25,
					"Time"  => 20
				);
			
			$this->addCols($size, $cols);

			$cols = array(
					"Client"  => "L",
					"Job ID"  => "L",
					"Type"  => "L",
					"Date"  => "L",
					"Time"  => "L"
				);
			$this->addLineFormat( $cols);
			$this->SetY(29);
		}
		
		function __construct($orientation, $metric, $size, $startdate, $enddate, $siteid) {
			$dynamicY = 0;
			
	        parent::__construct($orientation, $metric, $size);
	        
	        $this->SetAutoPageBreak(true, 30);
	        
			$this->AddPage();
			
			try {
				$and = "";
				
				if ($siteid != 0) {
					$and .= "AND A.clientid = $siteid ";
				}
				
				if ($startdate != "") {
					$startdate = convertStringToDate($startdate);
					$and .= "AND DATE(A.starttime) >= '$startdate' ";
				}
				
				if ($enddate != "") {
					$enddate = convertStringToDate($enddate);
					$and .= "AND DATE(A.starttime) <= '$enddate' ";
				}
				
				$sql = "SELECT A.*, 
						DATE_FORMAT(A.starttime, '%d/%m/%Y') AS starttime_date,
						B.name
						FROM {$_SESSION['DB_PREFIX']}diary A 
						INNER JOIN {$_SESSION['DB_PREFIX']}client B 
						ON B.id = A.clientid 
						WHERE A.jobreadytobeinvoiced = 'Y'
						$and
						ORDER BY B.name";
				$result = mysql_query($sql);
				
				if ($result) {
					while (($member = mysql_fetch_assoc($result))) {
						if ($member['jobvisittype'] == "P") {
							$jobtype = "Planned Service Visit";
							
						} else if ($member['jobvisittype'] == "A") {
							$jobtype = "Additional Free Visit";
							
						} else if ($member['jobvisittype'] == "C") {
							$jobtype = "Chargeable Visit";
							
						} else if ($member['jobvisittype'] == "S") {
							$jobtype = "Surveyors Visit";
						}
						
						$line = array(
								"Client"  => $member['name'],
            					"Job ID"  => $member['id'],
								"Type"  => $jobtype,
								"Date"  => $member['starttime_date'],
								"Time"  => $member['jobtime']
							);
							
							
						if ($this->GetY() > 260) {
							$this->AddPage();
						}
						
						$this->addLine( $this->GetY(), $line, 5.5);
					}
					
				} else {
					logError($sql . " - " . mysql_error());
				}
				
			} catch (Exception $e) {
				logError($e->getMessage());
			}
		}
	}
	
	start_db();
	
	$pdf = new ReadyToBeInvoicedReport( 'P', 'mm', 'A4', $_POST['datefrom'], $_POST['dateto'], $_POST['siteid']);
	$pdf->Output();
?>