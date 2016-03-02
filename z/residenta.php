<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');

if(empty($_GET)){
	if(empty($_POST)){
		('Location: index.php');
	}else{
		$locName=$_POST['locName'];
		$lid=$_POST['lid'];
		$uid=$_POST['uid'];
		$fName=$_POST['fName'];
		$lName=$_POST['lName'];
		$bDay=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
		$ecName=$_POST['ecName'];
		$ecNumber=$_POST['ecNumber'];
		$current=$_POST['current'];
		if($_POST['current']=="on"){
			$current=1;
		}else{
			$current=0;
		}
		$updatersql="INSERT INTO resident SET fName='$fName', lName='$lName', bDay='$bDay', ecName='$ecName', ecNumber='$ecNumber'";
		if(mysql_query($updatersql)){
			$lastInsertId=mysql_insert_id();
			$lsql="INSERT INTO lease_resident SET leaseId=$lid, residentId=$lastInsertId";
			if(mysql_query($lsql)){
				header("Location: unit.php?u=$locName");
			}
		}
	}
}else{
	$current=1;
	$locName=$_GET['u'];
	$lid=$_GET['l'];
	$sql="SELECT id FROM loc WHERE locName='$locName'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$uid=$row['id'];
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
			<h2>Add Resident to Unit: <?=$locName?></h2>
				<form action="residenta.php" method="post" class="resident">
					<fieldset>
						<legend>Details</legend>
						<div class="ques">
							<p class="l"><label for="current">Current Resident</label></p>
							<p class="i">
								<?php
									if($current==1){
										echo "<input name=\"current\" id=\"current\" type=\"checkbox\" checked />";
									}else{
										echo "<input name=\"current\" id=\"current\" type=\"checkbox\" />";
									}
								?>
							</p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
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
							<p class="i"><?php include('srp/selectPastDate.php') ?></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
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
						<input type="hidden" name="locName" value="<?=$locName?>" />
						<input type="hidden" name="uid" value="<?=$uid?>" />
						<input type="hidden" name="lid" value="<?=$lid?>" />
						<input class="submitbtn" type="submit" name="submit" value="Submit" /> <span class="secondlink"><a href="account.php">Cancel</a></span>
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