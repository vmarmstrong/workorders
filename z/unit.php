<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_GET)){
	('Location: index.php');
}else{
	$locName=strtoupper($_GET['u']);
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
			<h2>Location: <?=$locName?></h2>
			<ul id="unitnav"><!-- ====================== unit navigation -->
				<li><a href="view_unit" id="viewunit" class="active">Unit</a></li>
				<li><a href="view_lease" id="viewlease">Lease</a></li>
				<li><a href="view_residents" id="viewresidents">Residents</a></li>
				<li><a href="view_wo" id="viewwo">Workorders</a></li>
			</ul><!-- #unitnav -->
			<div class="clearfloat"></div>
			<div id="unit" class="user">
				<?php
					$usql="SELECT * FROM loc where locName='$locName'";
					$uresult=mysql_query($usql);
					$urow=mysql_fetch_array($uresult);
					$uId=$urow['id'];
					$size=$urow['bed']." / ".$urow['bath'];
					$building=$urow['building'];
					$floor=$urow['floor'];
					$mail=$urow['mailbox'];
					$fire=$urow['extinguisher'];
				?>
				<div class="ques">
					<p class="l">Unit Number</p>
					<p class="i"><?=$locName?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<div class="ques">
					<p class="l">Size</p>
					<p class="i"><?=$size?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<div class="ques">
					<p class="l">Building</p>
					<p class="i"><?=$building?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<div class="ques">
					<p class="l">Floor</p>
					<p class="i"><?=$floor?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<div class="ques">
					<p class="l">Mailbox</p>
					<p class="i"><?=$mail?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<div class="ques">
					<p class="l">Fire Extinquisher</p>
					<p class="i"><?=$fire?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<?php if($_SESSION['level']=="admin"){ ?>
				<div class="ques">
					<p><a class="icon" href="locm.php?l=<?=$uId?>"><img src="../img/icon/edit.png" title="Modify Unit Information" /></a></p>
				</div><!-- .ques -->
				<?php } ?>
		</div>
		<div id="lease" class="user hidden">
				<?php
					$lsql="SELECT * FROM lease WHERE locId=$uId AND NOW() BETWEEN startDate AND endDate";
					$lresult=mysql_query($lsql);
					$lrow=mysql_fetch_array($lresult);
					$lid=$lrow['id'];
					$lstart=$lrow['startDate'];
					$lend=$lrow['endDate'];
					$lrent=$lrow['rent'];
					$ldeposit=$lrow['deposit'];
				?>	
				<div class="ques">
					<p class="l">Start Date</p>
					<p class="i"><?=$lstart?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<div class="ques">
					<p class="l">End Date</p>
					<p class="i"><?=$lend?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<div class="ques">
					<p class="l">Rental Amount</p>
					<p class="i"><?=$lrent?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<div class="ques">
					<p class="l">Deposit Amount</p>
					<p class="i"><?=$ldeposit?></p>
					<div class="clearfloat"></div>
				</div><!-- .ques -->
				<?php if($_SESSION['level']=="admin" || $_SESSION['level']=="office"){ ?>
				<div class="ques">
					<p><a class="icon" href="leasem.php?l=<?=$lid?>"><img src="../img/icon/edit.png" title="Modify Lease Information" /></a> <a class="icon" href="leasea.php"><img src="../img/icon/add.png" title="Add Lease Information" /></a></p>
				</div><!-- .ques -->
				<?php } ?>
		</div>
		<div id="residents" class="user hidden">
					<?php
						$rsql="SELECT lr.residentId, r.fName, r.lName, r.bDay, r.ecName, r.ecNumber
							FROM lease_resident as lr
							LEFT JOIN resident as r ON (r.id=lr.residentId)
							WHERE lr.leaseId=$lid
							ORDER BY r.bDay";
						$rresult=mysql_query($rsql);
						while($rrow=mysql_fetch_assoc($rresult)){
							$rid=$rrow['residentId'];
							$fName=$rrow['fName'];
							$lName=$rrow['lName'];
							$bDay=$rrow['bDay'];
							$age = floor((time()-strtotime($bDay))/31536000);
							$ecName=$rrow['ecName'];
							$ecNumber=$rrow['ecNumber'];
							if($age>18){
								echo "<fieldset><legend>";
								if($_SESSION['level']=="admin"){ ?>
									<a class="icon" href="residentm.php?r=<?=$rid?>&u=<?=$locName?>"><img src="../img/icon/edit.png" title="Modify Resident Information" /></a>
							<?php }
							 	echo " $fName $lName</legend>";
								$psql="SELECT phone, type FROM r_phone WHERE residentId=$rid";
								$presult=mysql_query($psql);
								while($prow=mysql_fetch_assoc($presult)){
									$phone=$prow['phone'];
									$type=$prow['type'];
									echo "<div class=\"ques\">
											<p class=\"l\">$type Phone</p>
											<p class=\"i\">$phone</p>
											<div class=\"clearfloat\"></div>
										</div><!-- .ques -->";
								}
								$esql="SELECT email, type FROM r_email WHERE residentId=$rid";
								$eresult=mysql_query($esql);
								while($erow=mysql_fetch_assoc($eresult)){
									$email=$erow['email'];
									$type=$erow['type'];
									echo "<div class=\"ques\">
											<p class=\"l\">$type Email</p>
											<p class=\"i\">$email</p>
											<div class=\"clearfloat\"></div>
										</div><!-- .ques -->";
									
								}
								echo "<div class=\"ques\">
										<p class=\"l\">Emergency Contact Name</p>
										<p class=\"i\">$ecName</p>
										<div class=\"clearfloat\"></div>
									</div><!-- .ques -->
									<div class=\"ques\">
										<p class=\"l\">Emergency Contact Number</p>
										<p class=\"i\">$ecNumber</p>
										<div class=\"clearfloat\"></div>
									</div><!-- .ques -->";
							}else{
								echo "<fieldset><legend>";
								if($_SESSION['level']=="admin"){ ?>
									<a class="icon" href="residentm.php?r=<?=$rid?>&u=<?=$locName?>"><img src="../img/icon/edit.png" title="Modify Resident Information" /></a>
								<?php }
								
								echo " $fName $lName (minor)</legend>
									<div class=\"ques\">
										<p class=\"l\">Birthday</p>
										<p class=\"i\">$bDay</p>
										<div class=\"clearfloat\"></div>
									</div><!-- .ques -->";
							}
							echo "</fieldset>";
						}
					?>
					<div class="ques">
						<p class="i"><a class="icon" href="residenta.php?u=<?=$locName?>&l=<?=$lid?>"><img src="../img/icon/add.png" title="Add Resident Information" /> Add a new resident</a></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
				<div class="clearfloat"></div>
			</div>
			<table id="wo" class="user hidden" summary="This table is a summary of all workorders for this unit.">
				<thead>
					<tr>
						<th>Number</th>
						<th>Date</th>
						<th>Category</th>
						<th>Request</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$year=date('y',time());
					$wtable="wo_".$year;
					$wreq_table="wo_".$year."_req";
					$wsql="SELECT w.id, w.dateEntered, c.type AS category, s.type AS status, r.detailRequest
							FROM $wtable as w
							JOIN $wreq_table as r ON (w.id=r.woId)
							JOIN status as s ON (s.id=r.status)
							JOIN cats as c ON (c.id=r.category)
							WHERE w.locId='$uId'
							ORDER BY w.dateEntered";
					$wresult=mysql_query($wsql);
					while($wrow=mysql_fetch_assoc($wresult)){
						$wo=$year.$wrow['id'];
						$date=date('m/j/y',strtotime($wrow['dateEntered']));
						$cat=$wrow['category'];
						$request=$wrow['detailRequest'];
						$status=$wrow['status'];
						echo "<tr>
								<td><a href=\"wo.php?w=$wo\">$wo</a></td>
								<td>$date</td>
								<td>$cat</td>
								<td>$request</td>
								<td>$status</td>
							</tr>";
					}
				?>
				</tbody>
			</table>
		</div><!-- #display -->
	</div><!-- #content -->
	<div class="clearfloat"></div>
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php')?>
</body>
</html>