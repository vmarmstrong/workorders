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
	<link href='http://fonts.googleapis.com/css?family=Cantarell&subset=latin' rel='stylesheet' type='text/css'>	
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
			<li><a href="index.php" id="open" class="active">home</a></li>
			<li><a href="newwo.php" id="new">new workorder</a></li>
			<li><a href="report.php" id="report">report</a></li>
		</ul><!-- #nav -->
		<div id="display"><!-- ========= location of all result content -->
			<h2>Open Workorders</h2>
			<table summary="This table is a summary of all open workorders.">
				<thead>
					<tr>
						<th><a href="index.php?sortby=wo">Number</a></th>
						<th><a href="index.php?sortby=dateEntered">Date</a> </th>
						<th><a href="index.php?sortby=locName">Unit</a></th>
						<th>Request</th>
						<th><a href="index.php?sortby=status">Status</a></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$year=date('y',time());
					$year = 10;   //hard coded to show archive data
					$wo_table="wo_".$year;
					$wo_req_table="wo_".$year."_req";
					if($sort=="wo"){
						$sql="SELECT rq.woId, wo.dateEntered, l.locName, rq.detailRequest, s.type AS status
							FROM $wo_req_table as rq
							JOIN $wo_table as wo ON (wo.id=rq.woId)
							JOIN loc AS l ON (wo.locId=l.id)
							JOIN status as s ON (s.id=rq.status)
							WHERE NOT s.type='Completed' ORDER BY rq.woId DESC";
					}else if($sort=="locName"){
						$sql="SELECT rq.woId, wo.dateEntered, l.locName, rq.detailRequest, s.type AS status
							FROM $wo_req_table as rq
							JOIN $wo_table as wo ON (wo.id=rq.woId)
							JOIN loc AS l ON (wo.locId=l.id)
							JOIN status as s ON (s.id=rq.status)
							WHERE NOT s.type='Completed' ORDER BY l.locName DESC";
					}else if($sort=="status"){
						$sql="SELECT rq.woId, wo.dateEntered, l.locName, rq.detailRequest, s.type AS status
							FROM $wo_req_table as rq
							JOIN $wo_table as wo ON (wo.id=rq.woId)
							JOIN loc AS l ON (wo.locId=l.id)
							JOIN status as s ON (s.id=rq.status)
							WHERE NOT s.type='Completed' ORDER BY s.type DESC";
					}else{
						$sql="SELECT rq.woId, wo.dateEntered, l.locName, rq.detailRequest, s.type AS status
							FROM $wo_req_table as rq
							JOIN $wo_table as wo ON (wo.id=rq.woId)
							JOIN loc AS l ON (wo.locId=l.id)
							JOIN status as s ON (s.id=rq.status)
							WHERE NOT s.type='Completed' ORDER BY wo.dateEntered DESC";
					}
					$result=mysql_query($sql);
					while($row=mysql_fetch_assoc($result)){
						$wo=$year.$row['woId'];
						$date=date('m/j/y',strtotime($row['dateEntered']));
						$loc=$row['locName'];
						$request=$row['detailRequest'];
						$status=$row['status'];
						echo "<tr>
								<td><a href=\"wo.php?w=$wo\">$wo</a></td>
								<td>$date</td>
								<td>$loc</td>
								<td>$request</td>
								<td>$status</td>
							</tr>";
					}
				?>
				</tbody>
			</table>
		</div><!-- #display -->
		<div class="clearfloat"></div>
	</div><!-- #content -->
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php')?>
</body>
</html>