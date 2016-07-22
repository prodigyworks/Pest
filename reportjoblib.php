<?php
	require_once('system-db.php');
	require_once('pdfreport.php');
	require_once("simple_html_dom.php");
	
	class JobReport extends PDFReport {
		
		function AddPage($orientation='', $size='') {
			parent::AddPage($orientation, $size);
			
			$this->SetFontSize(8);
			$this->SetY(5);
		}
		
		function addCheckHeader($x, $y, $heading, $value) {
			if ($value == 1) {
				$this->Image("images/checkbox_on.png", $x + 1, $y);
				
			} else {
				$this->Image("images/checkbox_off.png", $x + 1, $y);
			}
			
			$y = $this->addText($x + 6, $y + 1, $heading);
			
			return $y;
		}
		
		function __construct($orientation, $metric, $size, $id) {
			$dynamicY = 0;
			
	        parent::__construct($orientation, $metric, $size);
	        
	        $this->SetAutoPageBreak(true, 30);
			
			try {
				$sql = "SELECT A.*, DATE_FORMAT(A.jobdate, '%d/%m/%Y') AS jobdate,
						B.name, B.imageid as customerimageid, B.address,
						C.fullname
						FROM {$_SESSION['DB_PREFIX']}diary A 
						INNER JOIN {$_SESSION['DB_PREFIX']}client B 
						ON B.id = A.clientid 
						INNER JOIN {$_SESSION['DB_PREFIX']}members C 
						ON C.member_id = A.memberid
						WHERE A.id = $id";
				$result = mysql_query($sql);
				
				if ($result) {
					while (($member = mysql_fetch_assoc($result))) {
						$this->AddPage();
						
						$y = $this->GetY();

						if ($member['customerimageid'] != 0) {
							$this->DynamicImage($member['customerimageid'], 163, $y, 30) + 1;
						}

						$y = $this->addText(15, $y, "Job Form", 11, 11, 'B') + 4;
						$y = $this->addHeading(15, $y, "Job Date", $member['jobdate']) + 1;
						$y = $this->addHeading(15, $y, "Time", $member['jobtime']) + 1;
						$y = $this->addHeading(15, $y, "Job ID", $member['id']) + 1;
						$y = $this->addHeading(15, $y, "Site", $member['name']) + 1;
						$y = $this->addHeading(15, $y, "Address", $member['jobaddress']) + 1;
						$y = $this->addHeading(15, $y, "Client Ref", $member['jobclientref']) + 1;
						$y = $this->addHeading(15, $y, "Job Ref Task", $member['jobreftask']) + 1;
						
						$y = $this->addText(15, $y + 4, "Pest Activity", 9, 9, 'B') + 4;
						
						$this->addCheckHeader(15, $y, "Rats", $member['jobactivity_rats']);
						$this->addCheckHeader(55, $y, "Mice", $member['jobactivity_mice']);
						$this->addCheckHeader(95, $y, "Cockroaches", $member['jobactivity_cockroaches']);
						$y = $this->addCheckHeader(135, $y, "Wasps", $member['jobactivity_wasps']) + 2;
						
						$this->addCheckHeader(15, $y, "Foxes", $member['jobactivity_foxes']);
						$this->addCheckHeader(55, $y, "Birds", $member['jobactivity_birds']);
						$this->addCheckHeader(95, $y, "Insects (Biting)", $member['jobactivity_bitinginsects']);
						$y = $this->addCheckHeader(135, $y, "Insects (Crawling)", $member['jobactivity_crawlinginsects']) + 2;
						
						$y = $this->addCheckHeader(15, $y, "No Pests", $member['jobactivity_nopests']) + 4;
						
						if ($member['jobvisittype'] == "P") {
							$visittype = "Planned Service Visit";
							
						} else if ($member['jobvisittype'] == "A") {
							$visittype = "Additional Free Visit";
							
						} else if ($member['jobvisittype'] == "C") {
							$visittype = "Chargeable Visit";
							
						} else if ($member['jobvisittype'] == "S") {
							$visittype = "Surveyors Visit";
						}
						
						$y = $this->addHeading(15, $y, "Visit Type", $visittype, 70) + 3;
						$y = $this->addHeading(15, $y, "Observations & Work Completed", $member['jobobservations'], 70) + 3;
						$y = $this->addHeading(15, $y, "Actions required for client", $member['jobactions'], 70) + 3;
						$y = $this->addHeading(15, $y, "Actions required by excelets", $member['jobexcelets'], 70) + 6;
						
						$y = $this->addHeading(15, $y, "Are mouse droppings present?", $member['jobmousedroppingspresent'] == "Y" ? "Yes" : "No", 70) + 3;
						$y = $this->addHeading(15, $y, "Are there hygiene faults?", $member['jobhygienefaults'] == "Y" ? "Yes" : "No", 70) + 3;
						$y = $this->addHeading(15, $y, "Animals/Children/vulnerable adults present?", $member['jobvulnerable'] == "Y" ? "Yes" : "No", 70) + 3;
						$y = $this->addHeading(15, $y, "Are there risks to food safety?", $member['jobfoodsafety'] == "Y" ? "Yes" : "No", 70) + 3;
						$y = $this->addHeading(15, $y, "Are there proofing faults?", $member['jobproofingfaults'] == "Y" ? "Yes" : "No", 70) + 3;
						$y = $this->addHeading(15, $y, "Is today's work complete?", $member['jobcomplete'] == "Y" ? "Yes" : "No", 70) + 3;
						
						$y = $this->addText(15, $y + 4, "EXTERNAL BAITING PRECAUTIONS", 9, 9, 'B') + 4;
						
						$y = $this->addHeading(15, $y, "External baiting precautions applicable?", $member['jobexternalbaiting'] == "Y" ? "Yes" : "No", 70) + 3;
						
						if ($member['jobexternalbaiting'] == "Y") {
							$y = $this->addHeading(15, $y, "Are there any possible non target species present?", $member['jobpossiblenonspeciespresent'] == "Y" ? "Yes" : "No", 70) + 3;
							$y = $this->addHeading(15, $y, "Has inspection for rodent carcass been made?", $member['jobrodentcarcass'] == "Y" ? "Yes" : "No", 70) + 3;
							$y = $this->addHeading(15, $y, "Has harbourage sites been identified?", $member['jobharbourage'] == "Y" ? "Yes" : "No", 70) + 3;
							$y = $this->addHeading(15, $y, "Could non chemical methods be used?", $member['jobnonchemical'] == "Y" ? "Yes" : "No", 70) + 3;
							$y = $this->addHeading(15, $y, "Has external bait been laid?", $member['jobbaitlaid'] == "Y" ? "Yes" : "No", 70) + 3;
							$y = $this->addHeading(15, $y, "Are external baits securely placed?", $member['jobexternalbaitsecure'] == "Y" ? "Yes" : "No", 70) + 3;
						}
						
						$y = $this->addHeading(15, $y + 3, "Pesticides Used", $member['jobpesticides'], 70) + 3;

						$y = $this->addText(15, $y + 2, "Client Signature", 9, 9, 'B') + 2;
						$y = $this->addText(15, $y + 3, $member['clientname']) + 1;

						$y = $this->DynamicImage($member['imageid'], 15, $y + 3) + 1;

						if ($member['jobimage1'] != 0 ||
							$member['jobimage2'] != 0 ||
							$member['jobimage3'] != 0 ||
							$member['jobimage4'] != 0) {

							$this->AddPage();

							$y = $this->GetY();

							if ($member['jobimage1'] != 0) {
								$y = $this->addText(15, $y + 2, "Image 1", 9, 9, 'B') + 2;
								$y = $y + $this->DynamicImage($member['jobimage1'], 15, $y) + 1;
							}

							if ($member['jobimage2'] != 0) {
								$y = $this->addText(15, $y + 2, "Image 2", 9, 9, 'B') + 2;
								$y = $y + $this->DynamicImage($member['jobimage2'], 15, $y) + 1;
							}

							if ($member['jobimage3'] != 0) {
								$y = $this->addText(15, $y + 2, "Image 3", 9, 9, 'B') + 2;
								$y = $y + $this->DynamicImage($member['jobimage3'], 15, $y) + 1;
							}

							if ($member['jobimage4'] != 0) {
								$y = $this->addText(15, $y + 2, "Image 4", 9, 9, 'B') + 2;
								$y = $y + $this->DynamicImage($member['jobimage4'], 15, $y) + 1;
							}
						}
					}
					
				} else {
					logError($sql . " - " . mysql_error());
				}
				
			} catch (Exception $e) {
				logError($e->getMessage());
			}
		}
	}
?>