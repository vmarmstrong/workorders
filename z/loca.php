<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if($_SESSION['level']=='admin'){
	if(empty($_POST)){
	}else{
		$locType=$_POST['locType'];
		$locName=$_POST['locName'];
		$bed=$_POST['bed'];
		$bath=$_POST['bath'];
		$building=$_POST['building'];
		if($_POST['floor']==""){
			$floor=0;
		}
		$mail=$_POST['mailbox'];
		$fire=$_POST['extinguisher'];
		$sql="INSERT INTO loc SET locType='$locType', locName='$locName', bed='$bed', bath='$bath', building='$building', floor=$floor, mailbox='$mail', extinguisher='$fire'";
		if(mysql_query($sql))
		{
			header("Location: locadmin.php");
		}
	}
}else{
	header("Location: index.php");
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
				<form action="loca.php" method="post" class="resident">
					<fieldset>
						<legend>Add New Location</legend>
						<div class="ques">
							<p class="l"><label for="locType">Location Type (unit or public)</label></p>
							<p class="i"><select id="locType" name="locType">
											<option value="unit" <?php if($locType=="unit"){echo "selected=\"selected\"";} ?>>Unit</option>
											<option value="public" <?php if($locType=="public"){echo "selected=\"selected\"";} ?>>Public</option>
										</select>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="locName">Location Name</label></p>
							<p class="i"><input name="locName" id="locName" type="text" value="<?=$locName?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="bed">Number of Bedrooms</label></p>
							<p class="i"><input name="bed" id="bed" type="text" value="<?=$bed?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="bath">Number of Bathrooms</label></p>
							<p class="i"><input name="bath" id="bath" type="text" value="<?=$bath?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="building">Building Number</label></p>
							<p class="i"><input name="building" id="building" type="text" value="<?=$building?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="floor">Floor Number</label></p>
							<p class="i"><input name="floor" id="floor" type="text" value="<?=$floor?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="mailbox">Mailbox Number</label></p>
							<p class="i"><input name="mailbox" id="mailbox" type="text" value="<?=$mail?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="extinguisher">Fire Extinguisher Number</label></p>
							<p class="i"><input name="extinguisher" id="extinguisher" type="text" value="<?=$fire?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</fieldset>
					<div class="clearfloat"></div>
					<div class="ques btns">
						<input class="submitbtn" type="submit" name="submit" value="Add" /> <span class="secondlink"><a href="locadmin.php">Cancel</a></span>
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