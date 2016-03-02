<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_GET)){
	if(empty($_POST)){
		('Location: index.php');
	}else{
		$pId=$_POST['pid'];
		$rId=$_POST['rid'];
		$phone=$_POST['phone'];
		$type=$_POST['type'];
		$updatesql="UPDATE r_phone SET phone='$phone', type='$type' WHERE id=$pId";
		if(mysql_query($updatesql))
		{
			header("Location: residentm.php?r=$rId");
		}
	}
}else{
	$pId=$_GET['p'];
	$rId=$_GET['r'];
	$sql="SELECT r.fName, r.lName, p.phone, p.type FROM resident AS r JOIN r_phone AS p ON (r.id=p.residentId) WHERE r.id=$rid AND p.id=$pId";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$fName=$row['fName'];
	$lName=$row['lName'];
	$phone=$row['phone'];
	$type=$row['type'];
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
				<form action="phonem.php" method="post" class="resident">
					<fieldset>
						<legend>Add Phone Number for <?=$fName?> <?=$lName?></legend>
						<div class="ques">
							<p class="l"><label for="phone">Phone</label></p>
							<p class="i"><input name="phone" id="phone" type="text" value="<?=$phone?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="type">Phone Type (Home, Mobile, Work)</label></p>
							<p class="i"><input name="type" id="type" type="text" value="<?=$type?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</fieldset>
					<div class="clearfloat"></div>
					<div class="ques btns">
						<input type="hidden" name="rid" value="<?=$rId?>" />
						<input type="hidden" name="pid" value="<?=$pId?>" />
						<input class="submitbtn" type="submit" name="submit" value="Add" /> <span class="secondlink"><a href="residentm.php?r=<?=$rId?>">Cancel</a></span>
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