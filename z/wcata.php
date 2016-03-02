<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if($_SESSION['level']!="admin"){
	header('Location: index.php');
}else{
	if(empty($_POST)){}else{
		$type=$_POST['type'];
		if($_POST['current']=="on"){
			$current=1;
		}else{
			$current=0;
		}
		$sql="INSERT INTO cats SET type='$type', current=$current";
		if(mysql_query($sql))
		{
			header("Location: wcadmin.php");
		}
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
				<form action="wcatm.php" method="post" class="resident">
					<fieldset>
						<legend>Add new category</legend>
						<div class="ques">
							<p class="l"><label for="type">Category Name</label></p>
							<p class="i"><input name="type" id="type" type="text" value="<?=$type?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="current">Currently Being Used</label></p>
							<p class="i">
								<?php
									if($current==1){
										echo "<input type=\"checkbox\" name=\"current\" id=\"current\" checked/>";
									}else{
										echo "<input type=\"checkbox\" name=\"current\" id=\"current\"/>";
									}
								?>
							</p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</fieldset>
					<div class="clearfloat"></div>
					<div class="ques btns">
						<input class="submitbtn" type="submit" name="submit" value="Edit" /> <span class="secondlink"><a href="wcadmin.php">Cancel</a></span>
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