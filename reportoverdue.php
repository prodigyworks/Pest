<?php
	require_once("system-header.php");
?>
<h2>Overdue</h2>
<br>
<form id="reportform" class="reportform" name="reportform" method="POST" action="reportoverduelib.php" target="_new">
	<table>
		<tr>
		<tr>
			<td>
				Site
			</td>
			<td>
				<?php createCombo("siteid", "id", "name", "{$_SESSION['DB_PREFIX']}client", "", false); ?>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				<a class="link1" href="javascript: runreport();"><em><b>Run Report</b></em></a>
			</td>
		</tr>
	</table>
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
</script>
<?php
	require_once("system-footer.php");
?>
