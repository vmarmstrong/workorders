<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
$key=$_GET['k'];
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
			<h2>Did you mean... ?</h2>
			<?php
				if(is_numeric($key)){
					$year=substr($key,0,2);
					$wtable="wo_".$year;
					$wreq_table="wo_".$year."_req";
					$wid=substr($key,2);
					$wsql="SELECT w.id, w.dateEntered, loc.locName, r.detailRequest, s.type AS status
							FROM $wtable AS w
							JOIN $wreq_table AS r ON (w.id=r.woId)
							JOIN loc as loc ON (w.locId=loc.id)
							JOIN status AS s ON (r.status=s.id)
							WHERE w.id=$wid";
					$wresult=mysql_query($wsql);
					if($wresult==NULL){}else{
						echo "<h3>Workorder</h3>
								<table summary=\"possible workorders\">
								<thead>
									<tr>
										<th>Number</th>
										<th>Date</th>
										<th>Unit</th>
										<th>Request</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>";
						while($wrow=mysql_fetch_assoc($wresult)){
							$id=$wrow['id'];
							$date=date('m/j/y',strtotime($wrow['dateEntered']));
							$locName=$wrow['locName'];
							$details=$wrow['detailRequest'];
							$status=$wrow['status'];
							echo "<tr>
									<td><a href=\"wo.php?w=$key\">$key</a></td>
									<td>$date</td>
									<td>$locName</td>
									<td>$details</td>
									<td>$status</td>
								</tr>";
						}
						echo "</tbody>
								</table>";
					}
				}
			?>
			<?php
				if(is_string($key)){
					$unit=strtoupper($key);
					$usql="SELECT * FROM loc where locName='$unit'";
					$uresult=mysql_query($usql);
					if($uresult==NULL){}else{
						if(mysql_num_rows($uresult)>0){
							echo "<table summary=\"possible units\">
									<thead>
										<tr>
											<th><h3>Unit</h3></th>
											<th>Size</th>
											<th>Building</th>
											<th>Floor</th>
										</tr>
									</thead>
									<tbody>";
							while($urow=mysql_fetch_assoc($uresult)){
								$uid=$urow['id'];
								$size=$urow['bed']." / ".$urow['bath'];
								$building=$urow['building'];
								$floor=$urow['floor'];
								echo "<tr>
										<td><a href=\"unit.php?u=$unit\">$unit</a></td>
										<td>$size</td>
										<td>$building</td>
										<td>$floor</td>
									</tr>";
							}
							echo "</tbody>
									</table>";
						}
					}
				}
			?>
			<?php
				if(is_string($key)){
					$res=strtoupper($key);
					$ressql="SELECT r.fName, r.lName, loc.id, loc.locName
							FROM resident as r
							JOIN lease_resident as lr ON (r.id=lr.residentId)
							JOIN lease as l ON (lr.leaseId=l.id)
							JOIN loc as loc ON (l.locId=loc.id)
							WHERE r.fName LIKE '%$res%' OR r.lName LIKE '%$res%'";
					$resresult=mysql_query($ressql);
					if($resresult==NULL){}else{
						if(!mysql_num_rows($resresult)){}else{
							echo "<h3>Residents</h3>
									<table summary=\"possible residents\">
									<thead>
										<tr>
											<th>Unit</th>
											<th>First Name</th>
											<th>Last Name</th>
										</tr>
									</thead>
									<tbody>";
							while($resrow=mysql_fetch_assoc($resresult)){
								$locName=$resrow['locName'];
								$fName=$resrow['fName'];
								$lName=$resrow['lName'];
								echo "<tr>
										<td><a href=\"unit.php?u=$locName\">$locName</a></td>
										<td>$fName</td>
										<td>$lName</td>
									</tr>";
							}
							echo "</tbody>
									</table>";
						}
					}
				}
			?>
			<?php
				if(is_string($key)){
					$vtagsql="SELECT v.make, v.model, v.color, r.id as rId, r.fName, r.lName, loc.id as locId, loc.locName
							FROM vehicle AS v
							JOIN resident_vehicle AS rv ON (v.id=rv.vehicleId)
							JOIN resident AS r ON (r.id=rv.residentId)
							JOIN lease_resident AS lr ON (r.id=lr.residentId)
							JOIN lease AS l ON (lr.leaseId=l.id)
							JOIN loc AS loc ON (l.locId=loc.id)
							WHERE v.tag LIKE '%$key%'";
					$vtagresult=mysql_query($vtagsql);
					if($vtagresult==NULL){}else{
						if(!mysql_num_rows($vtagresult)){
							$vmmsql="SELECT v.make, v.model, v.color, v.tag, r.id as rId, r.fName, r.lName, loc.id as locId, loc.locName
							FROM vehicle AS v
							JOIN resident_vehicle AS rv ON (v.id=rv.vehicleId)
							JOIN resident AS r ON (r.id=rv.residentId)
							JOIN lease_resident AS lr ON (r.id=lr.residentId)
							JOIN lease AS l ON (lr.leaseId=l.id)
							JOIN loc AS loc ON (l.locId=loc.id)
							WHERE v.make LIKE '%$key%' OR v.model LIKE '%$key%'";
							$vmmresult=mysql_query($vmmsql);
							if($vmmresult==NULL){}else{
								if(!mysql_num_rows($vmmresult)){}else{
								echo "<h3>Vehicles</h3>
										<table summary=\"possible vehicles\">
										<thead>
											<tr>
												<th>Make/Model</th>
												<th>Color</th>
												<th>Tag</th>
												<th>Resident</th>
											</tr>
										</thead>
										<tbody>";
								while($vmmrow=mysql_fetch_assoc($vmmresult)){
									$locId=$vmmrow['id'];
									$locName=$vmmrow['locName'];
									$car=$vmmrow['make']." ".$vmmrow['model'];
									$color=$vmmrow['color'];
									$tag=$vmmrow['tag'];
									$name=$vmmrow['fName']." ".$vmmrow['lName'];
									$rId=$vmmrow['rId'];
									echo "<tr>
											<td>$car</td>
											<td>$color</td>
											<td>$tag</td>
											<td><a href=\"residentm.php?r=$rId\">$name</td>
										</tr>";
								}
								echo "</tbody>
										</table>";
								}
							}
						}else{
							echo "<h3>Vehicles</h3>
									<table summary=\"possible vehicles\">
									<thead>
										<tr>
											<th>Make/Model</th>
											<th>Color</th>
											<th>Resident</th>
										</tr>
									</thead>
									<tbody>";
							while($vtagrow=mysql_fetch_assoc($vtagresult)){
								$locId=$vtagrow['id'];
								$locName=$vtagrow['locName'];
								$car=$vtagrow['make']." ".$vtagrow['model'];
								$color=$vtagrow['color'];
								$name=$vtagrow['fName']." ".$vtagrow['lName'];
								$rId=$vtagrow['rId'];
								echo "<tr>
										<td>$car</td>
										<td>$color</td>
										<td><a href=\"residentm.php?r=$rId\">$name</td>
									</tr>";
							}
							echo "</tbody>
									</table>";
						}
					}
				}
			?>
		</div><!-- #display -->
		<div class="clearfloat"></div>
	</div><!-- #content -->
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php')?>
</body>
</html>