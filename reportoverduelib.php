<?php
	require_once('system-db.php');
	require_once('pdfreport.php');
	require_once("simple_html_dom.php");
	
	class OverdueReport extends PDFReport {
		
		function AddPage($orientation='', $size='') {
			parent::AddPage($orientation, $size);
			
			$this->SetTextColor(0, 0, 0);
			$this->Image("images/logomain2.png", 148.6, 1);
			
			$size = $this->addText( 10, 13, "Overdue (1 Week)", 12, 4, 'B') + 5;
			$this->SetFont('Arial','', 8);
				
			$cols = array( 
					"Client"  => 55,
					"Job ID"  => 25,
					"Date"  => 20,
					"Status"  => 35,
					"Allocated To"  => 35,
					"Allocated On"  => 20
			);
			
			$this->addCols($size, $cols);

			$cols = array(
					"Client"  => "L",
					"Job ID"  => "L",
					"Status"  => "L",
					"Allocated To"  => "L",
					"Date"  => "L",
					"Allocated On"  => "L"
				);
			$this->addLineFormat( $cols);
			$this->SetY(29);
		}
		
		function __construct($orientation, $metric, $size, $siteid) {
			$dynamicY = 0;
			
	        parent::__construct($orientation, $metric, $size);
	        
	        $this->SetAutoPageBreak(true, 30);
			$this->AddPage();
			
			try {
				$and = "";
				
				if ($siteid != 0) {
					$and .= "AND A.clientid = $siteid ";
				}
				
				$sql = "SELECT A.*, 
						DATE_FORMAT(A.starttime, '%d/%m/%Y') AS starttime_date,
						DATE_FORMAT(A.allocateddate, '%d/%m/%Y') AS allocateddate,
						B.name,
						C.fullname
						FROM {$_SESSION['DB_PREFIX']}diary A 
						INNER JOIN {$_SESSION['DB_PREFIX']}client B 
						ON B.id = A.clientid 
						LEFT OUTER JOIN {$_SESSION['DB_PREFIX']}members C 
						ON C.member_id = A.memberid 
						WHERE A.starttime < DATE_ADD(CURDATE(), INTERVAL -7 DAY)
						AND A.status != 'C'
						$and
						ORDER BY A.starttime";
				$result = mysql_query($sql);
				
				if ($result) {
					while (($member = mysql_fetch_assoc($result))) {
						if ($member['status'] == "N") {
							$jobtype = "New";
							$this->SetTextColor(0, 0, 0);
							
						} else if ($member['status'] == "A") {
							$jobtype = "Allocated";
							$this->SetTextColor(255, 0, 0);
							
						} else if ($member['status'] == "U") {
							$jobtype = "Unallocated";
							$this->SetTextColor(0, 0, 255);
						}
						
						$line = array(
								"Client"  => $member['name'],
            					"Job ID"  => $member['id'],
								"Status"  => $jobtype,
								"Allocated To"  => $member['fullname'],
								"Date"  => $member['starttime_date'],
								"Allocated On"  => $member['allocateddate']
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
	
	$pdf = new OverdueReport( 'P', 'mm', 'A4', $_POST['siteid']);
	$pdf->Output();
?>