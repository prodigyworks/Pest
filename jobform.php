<?php include("system-mobileheader.php"); ?>
<script src='js/jquery.ui.timepicker.js'></script>
<style>
	form {
		padding:5px;
	}
	.jobexternalbaiting_div {
		display: none;
	}
</style>
<form class="contentform" id="reportform" method="post" enctype="multipart/form-data" action="jobformpost.php">
	<table cellspacing=7>
		<tr>
			<td>Technician</td>
			<td>
				<div><?php echo GetUserName(); ?></div>
			</td>
		</tr>
		<tr>
			<td>Date</td>
			<td>
				<input type="date" id="jobdate" name="jobdate" required value="<?php echo date("Y-m-d"); ?>" required="true" />
			</td>
		</tr>
		<tr>
			<td>Time</td>
			<td>
				<input type="time" id="jobtime" name="jobtime" required value="<?php echo date("H:i"); ?>" required="true" />
			</td>
		</tr>
		<tr>
			<td>Job ID</td>
			<td>
				<?php createCombo("jobid", "id", "id", "{$_SESSION['DB_PREFIX']}diary", "WHERE status = 'A' AND memberid = " . getLoggedOnMemberID()); ?>
			</td>
		</tr>
		<tr>
			<td>Site</td>
			<td>
				<input type="text" id="fullname" name="fullname" disabled />
			</td>
		</tr>
		<tr>
			<td>Address</td>
			<td>
				<textarea id="jobaddress" name="jobaddress" cols=60 rows=5></textarea>
			</td>
		</tr>
		<tr>
			<td>Client Ref</td>
			<td>
				<input type="text" id="jobclientref" name="jobclientref" />
			</td>
		</tr>
		<tr>
			<td>Ref / Task</td>
			<td>
				<input type="text" id="jobreftask" name="jobreftask" />
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Pest Activity</td>
		</tr>
		<tr>
			<td colspan=2>
				<table cellspacing=10>
					<tr>
						<td>
							<input type="checkbox" id="jobactivity_rats" name="jobactivity_rats"> Rats </input>
						</td>
						<td>
							<input type="checkbox" id="jobactivity_mice" name="jobactivity_mice"> Mice </input>
						</td>
						<td>
							<input type="checkbox" id="jobactivity_cockroaches" name="jobactivity_cockroaches"> Cockroaches </input>
						</td>
						<td>
							<input type="checkbox" id="jobactivity_wasps" name="jobactivity_wasps"> Insects (flying) </input>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" id="jobactivity_foxes" name="jobactivity_foxes"> Other </input>
						</td>
						<td>
							<input type="checkbox" id="jobactivity_birds" name="jobactivity_birds"> Birds </input>
						</td>
						<td>
							<input type="checkbox" id="jobactivity_bitinginsects" name="jobactivity_bitinginsects"> Insects (Biting) </input>
						</td>
						<td>
							<input type="checkbox" id="jobactivity_crawlinginsects" name="jobactivity_crawlinginsects"> Insects (Crawling) </input>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" id="jobactivity_nopests" name="jobactivity_nopests"> No Pests </input>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Visit Type</td>
		</tr>
		<tr>
			<td colspan=2>
				<SELECT id="jobvisittype" name="jobvisittype">
					<OPTION value="P">Planned Service Visit</OPTION>
					<OPTION value="A">Additional Free Visit</OPTION>
					<OPTION value="C">Chargeable Visit</OPTION>
					<OPTION value="S">Surveyors Visit</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Observations & Work Completed</td>
		</tr>
		<tr>
			<td colspan=2>
				<textarea id="jobobservations" name="jobobservations" cols=60 rows=5></textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Actions required for client</td>
		</tr>
		<tr>
			<td colspan=2>
				<textarea id="jobactions" name="jobactions" cols=60 rows=5></textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Actions required by excelets</td>
		</tr>
		<tr>
			<td colspan=2>
				<textarea id="jobexcelets" name="jobexcelets" cols=60 rows=5></textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Are mouse droppings present?</td>
		</tr>
		<tr>
			<td colspan=2>
				<SELECT id="jobmousedroppingspresent" name="jobmousedroppingspresent">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Are there hygiene faults?</td>
		</tr>
		<tr>
			<td colspan=2>
				<SELECT id="jobhygienefaults" name="jobhygienefaults">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Animals/Children/vulnerable adults present?</td>
		</tr>
		<tr>
			<td colspan=2>
				<SELECT id="jobvulnerable" name="jobvulnerable">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Are there risks to food safety?</td>
		</tr>
		<tr>
			<td colspan=2>
				<SELECT id="jobfoodsafety" name="jobfoodsafety">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Are there proofing faults?</td>
		</tr>
		<tr>
			<td colspan=2>
				<SELECT id="jobproofingfaults" name="jobproofingfaults">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>Is today's work complete?</td>
		</tr>
		<tr>
			<td colspan=2>
				<SELECT id="jobcomplete" name="jobcomplete">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2 class="formheading">EXTERNAL BAITING PRECAUTIONS</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2>External baiting precautions applicable?</td>
		</tr>
		<tr>
			<td colspan=2>
				<SELECT id="jobexternalbaiting" name="jobexternalbaiting">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>Are there any possible non target species present?</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>
				<SELECT id="jobpossiblenonspeciespresent" name="jobpossiblenonspeciespresent">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>Has inspection for rodent carcass been made?</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>
				<SELECT id="jobrodentcarcass" name="jobrodentcarcass">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>Has harbourage sites been identified?</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>
				<SELECT id="jobharbourage" name="jobharbourage">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>Could non chemical methods be used?</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>
				<SELECT id="jobnonchemical" name="jobnonchemical">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>Has external bait been laid?</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>
				<SELECT id="jobbaitlaid" name="jobbaitlaid">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>Are external baits securely placed?</td>
		</tr>
		<tr class="jobexternalbaiting_div">
			<td colspan=2>
				<SELECT id="jobexternalbaitsecure" name="jobexternalbaitsecure">
					<OPTION value="N">No</OPTION>
					<OPTION value="Y">Yes</OPTION>
				</SELECT>
			</td>
		</tr>

		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td>Client Signature</td>
			<td>
<?php 
	require_once('signature.php');

	addSignatureForm();
?>
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td>Image 1</td>
			<td>
				<input type="file" id="jobimage1" name="jobimage1"  />
			</td>
		</tr>
		<tr>
			<td>Image 2</td>
			<td>
				<input type="file" id="jobimage2" name="jobimage2"  />
			</td>
		</tr>
		<tr>
			<td>Image 3</td>
			<td>
				<input type="file" id="jobimage3" name="jobimage3"  />
			</td>
		</tr>
		<tr>
			<td>Image 4</td>
			<td>
				<input type="file" id="jobimage4" name="jobimage4"  />
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td>Pesticides Used</td>
			<td>
				<input type="number" id="jobpesticides" name="jobpesticides"  />
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td>Email 1</td>
			<td>
				<input type="email" size=40 id="email1" name="email1"  />
			</td>
		</tr>
		<tr>
			<td>Email 2</td>
			<td>
				<input type="email" size=40 id="email2" name="email2"  />
			</td>
		</tr>
		<tr>
			<td>Email 3</td>
			<td>
				<input type="email" size=40 id="email3" name="email3"  />
			</td>
		</tr>
	</table>
	<br>
	<a class="submit" href="javascript: runreport();"><em><b>Submit</b></em></a>
</form>
<script>
	function runreport(e) {
		if (! verifyStandardForm("#reportform")) {
			return false;
		}
	
		$('#reportform').submit();
	
		try {
			e.preventDefault();
	
		} catch (e) {
	
		}
	}

	$(document).ready(
			function() {
				$('.sigPad').signaturePad(
			  			{
			  				validateFields: false
			  			}
					);

				$("#jobexternalbaiting").change(
						function() {
							if ($(this).val() == "Y") {
								$(".jobexternalbaiting_div").show();
								
							} else {
								$(".jobexternalbaiting_div").hide();
							}
						}
					);

				$("#jobid").change(
						function() {
							callAjax(
									"finddata.php", 
									{ 
										sql: "SELECT B.name, B.address, A.jobobservations, A.jobvisittype " +
											 "FROM <?php echo $_SESSION['DB_PREFIX'];?>diary A " + 
											 "INNER JOIN <?php echo $_SESSION['DB_PREFIX'];?>client B " + 
											 "ON B.id = A.clientid " + 
											 "WHERE A.id = " + $(this).val()
									},
									function(data) {
										if (data.length > 0) {
											$("#fullname").val(data[0].name);
											$("#jobobservations").val(data[0].jobobservations);
											$("#jobaddress").val(data[0].address);
											$("#jobvisittype").val(data[0].jobvisittype);

										} else {
											$("#fullname").val("");
											$("#jobaddress").val("");
										}
									}
								);	
						}
					);
<?php 
				if (isset($_GET['id'])) {
?>
				$("#jobid").val("<?php echo $_GET['id']; ?>").trigger("change");
<?php
				}
?>
			}
		);
</script>

<?php include("system-mobilefooter.php"); ?>
