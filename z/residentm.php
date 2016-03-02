<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_GET)){
	if(empty($_POST)){
		('Location: index.php');
	}else{
		$rid=$_POST['rid'];
		$locName=$_POST['locName'];
		$fName=$_POST['fName'];
		$lName=$_POST['lName'];
		$bDay=$_POST['bDay'];
		$ecName=$_POST['ecName'];
		$ecNumber=$_POST['ecNumber'];
		$updatesql="UPDATE resident SET fName='$fName', lName='$lName', bDay=$bDay, ecName='$ecName', ecNumber='$ecNumber' WHERE id=$rid";
		if(mysql_query($updatesql))
		{
			header('Location: index.php');
		}
	}
}else{
	$rid=$_GET['r'];
	$locName=$_GET['u'];
	$rsql="SELECT r.fName, r.lName, r.bDay, r.ecName, r.ecNumber FROM resident as r WHERE r.id=$rid";
	$rresult=mysql_query($rsql);
	$rrow=mysql_fetch_array($rresult);
	$fName=$rrow['fName'];
	$lName=$rrow['lName'];
	$bDay=$rrow['bDay'];
	$age = floor((time()-strtotime($bDay))/31536000);
	$ecName=$rrow['ecName'];
	$ecNumber=$rrow['ecNumber'];
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
			<h2>Resident: 
				<?php
					echo $fName." ".$lName;
					if($age<18){
					echo " (minor)";
					}
			   ?>
			</h2>
				<form action="residentm.php" method="post" class="resident">
					<fieldset>
						<legend>Details</legend>
						<div class="ques">
							<p class="l"><label for="fName">First Name</label></p>
							<p class="i"><input name="fName" id="fName" type="text" value="<?=$fName?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="lName">Last Name</label></p>
							<p class="i"><input name="lName" id="lName" type="text" value="<?=$lName?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="bday">Birthday</label></p>
							<p class="i"><input name="bday" type="bday" value="<?=$bDay?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</fieldset>
					<fieldset>
						<legend>Phone Numbers <a class="icon" href="phonea.php?r=<?=$rid?>"><img src="../img/icon/add.png" title="Add Phone Number" /></a></legend>
						<?php
							$psql="SELECT id, phone, type FROM r_phone WHERE residentId=$rid";
							$presult=mysql_query($psql);
							while($prow=mysql_fetch_assoc($presult)){
								$pId=$prow['id'];
								$phone=$prow['phone'];
								$type=$prow['type'];
								echo "<div class=\"ques\">
										<p class=\"l\">$type Phone</p>
										<p class=\"i\">$phone <a class=\"icon\" href=\"phonem.php?p=$pId&r=$rid\"><img src=\"../img/icon/edit.png\" title=\"Modify Phone Number\" /></a> <a class=\"icon\" href=\"srp/phoned.php?p=$pId&r=$rid\"><img src=\"../img/icon/delete.png\" title=\"Delete Phone Number\" /></a></p>
										<div class=\"clearfloat\"></div>
									</div><!-- .ques -->";
							}
						?>
					</fieldset>
					<fieldset>
						<legend>Email Addresses <!-- <p><a href="emaila.php?r=<?=$rid?>">[+]</a></p> --></legend>
						<?php
							$esql="SELECT id, email, type FROM r_email WHERE residentId=$rid";
							$eresult=mysql_query($esql);
							while($erow=mysql_fetch_assoc($eresult)){
								$eId=$erow['id'];
								$email=$erow['email'];
								$type=$erow['type'];
								echo "<div class=\"ques\">
										<p class=\"l\">$type Email</p>
										<p class=\"i\">$email <a class=\"icon\" href=\"emailm.php?e=$eId&r=$rid\"><img src=\"../img/icon/edit.png\" title=\"Modify Email Address\" /></a> <a class=\"icon\" href=\"srp/emaild.php?e=$eId\"><img src=\"../img/icon/delete.png\" title=\"Delete Email Address\" /></a></p>
										<div class=\"clearfloat\"></div>
									</div><!-- .ques -->";
							}
						?>
					</fieldset>
					<fieldset>
						<legend>Vehicles <a class="icon" href="vehiclea.php?r=<?=$rid?>"><img src="../img/icon/add.png" title="Add Vehicle" /></a></legend>
						<?php
							$vsql="SELECT v.id, v.make, v.model, v.year, v.color, v.tag, v.state
									FROM vehicle as v
									JOIN resident_vehicle as rv ON (v.id=rv.vehicleId)
									WHERE rv.residentId=$rid";
							$vresult=mysql_query($vsql);
							while($vrow=mysql_fetch_assoc($vresult)){
								$vId=$vrow['id'];
								$make=$vrow['make'];
								$model=$vrow['model'];
								$vyear=$vrow['year'];
								$color=$vrow['color'];
								$tag=$vrow['tag'];
								$st=$vrow['state'];
								echo "<div class=\"ques\">
										<p class=\"l\">vehicle</p>
										<p class=\"i\">$make $model <a class=\"icon\" href=\"vehiclem.php?v=$vId&r=$rid&u=$locName\"><img src=\"../img/icon/edit.png\" title=\"Modify Vehicle Information\" /></a> <a class=\"icon\" href=\"srp/vehicled.php?v=$vId&r=$rid&u=$locName\"><img src=\"../img/icon/delete.png\" title=\"Delete Vehicle Information\" /></a></p>
										<div class=\"clearfloat\"></div>
									</div><!-- .ques -->";
							}
						?>
					</fieldset>
					<fieldset>
						<legend>Emergency Contact</legend>
						<div class="ques">
							<p class="l"><label for="ecName">Emergency Contact Name</label></p>
							<p class="i"><input name="ecName" id="ecName" type="text" value="<?=$ecName?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="ecNumber">Emergency Contact Number</label></p>
							<p class="i"><input name="ecNumber" type="ecNumber" value="<?=$ecNumber?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</fieldset>
					<div class="clearfloat"></div>
					<div class="ques btns">
						<input type="hidden" name="rid" value="<?=$rid?>" />
						<input type="hidden" name="locName" value="<?=$locName?>" />
						<input class="submitbtn" type="submit" name="submit" value="Submit" /> <span class="secondlink"><a href="unit.php?u=<?=$locName?>">Cancel</a></span>
					</div><!-- .ques -->
				</form>
		</div><!-- #display -->
	</div><!-- #content -->
	<div class="clearfloat"></div>
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php')?>
</body>
</html>