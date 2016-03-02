<?php /*last update: 11/2010 */ ?>

<?php
	require('srp/protect.php');
	require('srp/requiredb.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>TimelyTask: Workorder System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="../css/global.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="../js/vm.js"></script>
	<?php include('../meta.php'); ?>
	<?php include('../analytics.php'); ?>
</head>
<body>
<!-- ============================================================== TOP -->
<?php include('srp/bgtop.php')?>
<!-- =========================================================== MIDDLE -->
<div id="bgmid">
	<div id="content">
		<ul id="nav"><!-- ====================== side button navigation -->
			<li><a href="index.php" id="open">home</a></li>
			<li><a href="newwo.php" id="new">new workorder</a></li>
			<li><a id="report" class="active">report</a></li>
		</ul><!-- #nav -->
		<div id="display"><!-- ========= location of all result content -->
			<h2>Search for </h2>
			<form name="reportform" action="report.php" method="post">
				<p>Select all <select class="sortSelect" name="rpage" id="rpage">
					<option></option>
					<option value="wo">Workorders</option>
					<option value="unit">Units</option>
					<option value="lease">Leases</option>
					<option value="res">Residents</option>
				</select></p>
				<div class="sortoptions hidden"></div>
				<p><input id="reportbtn" class="submitbtn" type="submit" name="submit" value="Submit" /> <span class="secondlink"><a href="index.php">Cancel</a></span></p>
			</form>
			<div id="reportDisplay" class="hidden"></div><!-- #reportDisplay -->
		</div><!-- #display -->
	</div><!-- #content -->
	<div class="clearfloat"></div>
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php')?>
</body>
</html>