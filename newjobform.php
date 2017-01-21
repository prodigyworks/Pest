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
<form class="contentform" method="post" enctype="multipart/form-data" action="newjobformpost.php">
	<table cellspacing=7>
		<tr>
			<td>Date</td>
			<td>
				<input type="date" id="jobdate" name="jobdate" required value="<?php echo date("Y-m-d"); ?>" />
			</td>
		</tr>
		<tr>
			<td>Time</td>
			<td>
				<input type="time" id="jobtime" name="jobtime" required value="<?php echo date("H:i"); ?>" />
			</td>
		</tr>
		<tr>
			<td>Site</td>
			<td>
				<?php createCombo("siteid", "id", "name", "{$_SESSION['DB_PREFIX']}client", "WHERE status = 'L'"); ?>
			</td>
		</tr>
		<tr>
			<td>Address</td>
			<td>
				<textarea id="jobaddress" name="jobaddress" cols=60 rows=5></textarea>
			</td>
		</tr>
		<tr>
			<td>Type</td>
			<td>
				<SELECT id="jobvisittype" name="jobvisittype">
					<OPTION value="P">Planned Service Visit</OPTION>
					<OPTION value="A">Additional Free Visit</OPTION>
					<OPTION value="C">Chargeable Visit</OPTION>
					<OPTION value="S">Surveyors Visit</OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td>Comments</td>
			<td>
				<textarea id="jobobservations" name="jobobservations" cols=60 rows=5></textarea>
			</td>
		</tr>
		<tr>
			<td>Ready To Be Invoiced?</td>
			<td>
				<input type="checkbox" id="jobreadytobeinvoiced" name="jobreadytobeinvoiced" />
			</td>
		</tr>
		<tr>
			<td>Auto Allocate?</td>
			<td>
				<input type="checkbox" id="jobautoallocate" name="jobautoallocate" />
			</td>
		</tr>
	</table>
	<input type="submit" />
</form>
<script>
	$(document).ready(
			function() {
				$("#siteid").change(
						function() {
							callAjax(
									"finddata.php", 
									{ 
										sql: "SELECT B.address " +
											 "FROM <?php echo $_SESSION['DB_PREFIX'];?>client B " + 
											 "WHERE B.id = " + $(this).val()
									},
									function(data) {
										if (data.length > 0) {
											$("#jobaddress").val(data[0].address);

										} else {
											$("#jobaddress").val("");
										}
									}
								);	
						}
					);
			}
		);
</script>

<?php include("system-mobilefooter.php"); ?>
