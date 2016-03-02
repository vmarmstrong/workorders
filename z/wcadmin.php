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
			<h2>Workorder Categories</h2>
			<table summary="This table is a list of workorder category types.">
				<thead>
					<tr>
						<th><a href="wcadmin.php?sortby=type"><abbr title="This is the name that will appear in the workorder page.">Category</abbr></a></th>
						<th><a href="wcadmin.php?sortby=current"><abbr title="If Yes, this category will be available in the workorder form.  If No, this category is no longer available for use but is kept in the database for previous workorders history.">Currently being used</abbr></a></th>
						<th><a class="icon" href="wcata.php"><img src="../img/icon/add.png" title="Add new category" /></a></th>
					</tr>
				</thead>
				<tbody>
				<?php
					if($sort){
						$sql="SELECT * FROM cats ORDER BY $sort";
					}else{
						$sql="SELECT * FROM cats";
					}
					$result=mysql_query($sql);
					while($row=mysql_fetch_assoc($result)){
						$cId=$row['id'];
						$ctype=$row['type'];
						if($row['current']==1){
							$ccurrent="Yes";
						}else{
							$ccurrent="No";
						}
						echo "<tr><td>$ctype</td><td>$ccurrent</td><td><a class=\"icon\" href=\"wcatm.php?c=$cId\"><img src=\"../img/icon/edit.png\" title=\"Edit this category\" /></a></td></tr>";
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