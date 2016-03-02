<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if($_SESSION['level']!="admin"){
	header('Location: index.php');
}else{
	if($_GET){
		$sort=$_GET['sortby'];
	}
}
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
		<?php include('srp/nav.php')?>
		<div id="display"><!-- ========= location of all result content -->
			<h2>Units & Grounds</h2>
			<table summary="This table is a list of employees and vendors.">
				<thead>
					<tr>
						<th><a href="locadmin.php?sortby=locType"><abbr title="Type of location. Either Unit or Public.">Type</abbr></a></th>
						<th><a href="locadmin.php?sortby=locName"><abbr title="Name of the location.">Name</abbr></a></th>
						<th><a href="locadmin.php?sortby=building"><abbr title="Building number of the location.">Building</abbr></a></th>
						<th><a href="locadmin.php?sortby=bed"><abbr title="Number of bedrooms in the unit.">Bed</abbr></a></th>
						<th><a href="locadmin.php?sortby=bath"><abbr title="Number of bathrooms in the unit.">Bath</abbr></a></th>
						<th><a href="locadmin.php?sortby=floor"><abbr title="What floor the unit is on.">Floor</abbr></a></th>
						<th><a href="locadmin.php?sortby=mailbox"><abbr title="Mailbox number for the unit.">Mailbox</abbr></a></th>
						<th><a href="locadmin.php?sortby=extinguisher"><abbr title="Fire extinguisher number for the unit.">Extinguisher</abbr></a></th>
						<th><a class="icon" href="loca.php"><img src="../img/icon/add.png" title="Add new location" /></a></th>
					</tr>
				</thead>
				<tbody>
				<?php
					if($sort){
						$sql="SELECT * FROM loc ORDER BY $sort";
					}else{
						$sql="SELECT * FROM loc";
					}
					$result=mysql_query($sql);
					while($row=mysql_fetch_assoc($result)){
						$locId=$row['id'];
						$locType=$row['locType'];
						$locName=$row['locName'];
						$bed=$row['bed'];
						$bath=$row['bath'];
						$building=$row['building'];
						if($row['floor']==0){
							$floor="";
						}else{
							$floor=$row['floor'];
						}
						$mail=$row['mailbox'];
						$fire=$row['extinguisher'];
						echo "<tr>
								<td>$locType</td>
								<td>$locName</td>
								<td>$building</td>
								<td>$bed</td>
								<td>$bath</td>
								<td>$floor</td>
								<td>$mail</td>
								<td>$fire</td>
								<td><a class=\"icon\" href=\"locm.php?l=$locId\"><img src=\"../img/icon/edit.png\" title=\"Edit this status\" /></a></td></tr>";
					}
				?>
				</tbody>
			</table>
			<p><a class="back" href="account.php">Back to Account Page</a></p>
		</div><!-- #display -->
	</div><!-- #content -->
	<div class="clearfloat"></div>
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php')?>
</body>
</html>