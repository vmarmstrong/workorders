<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if($_GET){
	$sort=$_GET['sortby'];
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
			<h2 id="ltPgHead">Employees and Vendors</h2>
			<p id="rtPgHead"><?=$changeView?></p>
			<table summary="This table is a list of employees and vendors.">
				<thead>
					<tr>
						<th><a href="useradmin.php?sortby=fName">First</a></th>
						<th><a href="useradmin.php?sortby=lName">Last</a></th>
						<th><a href="useradmin.php?sortby=title">Title</a></th>
						<th><a href="useradmin.php?sortby=level">Access Level</a></th>
						<th><a class="icon" href="usera.php"><img src="../img/icon/add.png" title="Add new employee or vendor" /></a></th>
					</tr>
				</thead>
				<tbody>
				<?php
					if($status==c){
						if($sort){
							$sql="SELECT id, fName, lName, title, level, current FROM employee WHERE current=1 ORDER BY $sort";
						}else{
							$sql="SELECT id, fName, lName, title, level, current FROM employee WHERE current=1";
						}
					}else if($status==p){
						if($sort){
							$sql="SELECT id, fName, lName, title, level, current FROM employee WHERE current=0 ORDER BY $sort";
						}else{
							$sql="SELECT id, fName, lName, title, level, current FROM employee WHERE current=0";
						}
					}else{
						if($sort){
							$sql="SELECT id, fName, lName, title, level, current FROM employee ORDER BY $sort";
						}else{
							$sql="SELECT id, fName, lName, title, level, current FROM employee";
						}
					}
					$result=mysql_query($sql);
						while($row=mysql_fetch_assoc($result)){
							$id=$row['id'];
							$fName=$row['fName'];
							$lName=$row['lName'];
							$title=$row['title'];
							$level=$row['level'];
							echo "<tr>
									<td>$fName</td>
									<td>$lName</td>
									<td>$title</td>
									<td>$level</td>
									<td><a class=\"icon\" href=\"userm.php?id=$id\"><img src=\"../img/icon/edit.png\" title=\"Edit this status\" /></a></td>
								</tr>";
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