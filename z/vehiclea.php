<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_GET)){
	if(empty($_POST)){
		('Location: index.php');
	}else{
		$rId=$_POST['rId'];
		$make=$_POST['make'];
		$model=$_POST['model'];
		$vyear=$_POST['vyear'];
		$color=$_POST['color'];
		$tag=$_POST['tag'];
		$st=$_POST['st'];
		$vsql="INSERT INTO vehicle SET make='$make', model='$model', year='$vyear', color='$color', tag='$tag', state=$st";
		if(mysql_query($vsql))
		{
			$last_insert_id=mysql_insert_id();
			$rvsql="INSERT INTO resident_vehicle SET residentId=$rId, vehicleId=$last_insert_id";
			if(mysql_query($rvsql)){
				header("Location: residentm.php?r=$rId");
			}
		}
	}
}else{
	$rId=$_GET['r'];
	$sql="SELECT fName, lName FROM resident WHERE id=$rid";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$fName=$rrow['fName'];
	$lName=$rrow['lName'];
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
				<form action="vehiclea.php" method="post" class="resident">
					<fieldset>
						<legend>Add Vehicle for <?=$fName?> <?=$lName?></legend>
						<div class="ques">
							<p class="l"><label for="make">Make</label></p>
							<p class="i"><input name="make" id="make" type="text" value="<?=$make?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="model">Model</label></p>
							<p class="i"><input name="model" id="model" type="text" value="<?=$model?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="vyear">Year</label></p>
							<p class="i"><input name="vyear" id="vyear" type="text" value="<?=$vyear?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="color">Color</label></p>
							<p class="i"><input name="color" id="color" type="text" value="<?=$color?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="tag">Tag</label></p>
							<p class="i"><input name="tag" id="tag" type="text" value="<?=$tag?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="st">State</label></p>
							<p class="i"><select name="st" id="st">
								<option value="none"> </option>
								<?php
									$ssql="SELECT * FROM state ORDER BY id";
									$sresult=mysql_query($ssql);
									while($srow=mysql_fetch_assoc($sresult)){
										$sId=$srow['id'];
										$sdisplay=$srow['name']." (".$srow['abr'].")";
										if($st==$sid){
											echo "<option value=\"$sId\" selected=\"selected\">$sdisplay</option>";
										}else{
											echo "<option value=\"$sId\">$sdisplay</option>";
										}
									}
								?></select>
							</p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</fieldset>
					<div class="clearfloat"></div>
					<div class="ques btns">
						<input type="hidden" name="rId" value="<?=$rId?>" />
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