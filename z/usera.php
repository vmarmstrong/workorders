<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_POST)){
	$current==1;
}else{
	$id=$_POST['id'];
	if($current=="on"){
		$current=1;
	}else{
		$current=0;
	}
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$title=$_POST['title'];	
	$level=$_POST['level'];
	$phone=$_POST['phone'];
	$service=$_POST['service'];
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$csql="SELECT * FROM employee WHERE username=$username";
	$cresult=mysql_query($csql);
	if(mysql_num_rows($cresult)>=1){
		$userError="That username is already being used.";
	}else{
		$sql="UPDATE employee SET current=$current, fName='$fname', lName='$lname', title='$title', level='$level', phone='$phone', service='$service', username='$username', password='$password' WHERE id='$id'";
		if(mysql_query($sql)){
			('Location: useradmin.php');
		}else{
			$formstatus="The data has not been saved.";
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
			<h2>Edit user information</h2>
			<p><?=$formstatus?></p>
			<form action="usera.php" method="post" class="user">
				<fieldset>
					<legend>User</legend>
					<div class="ques">
						<p class="l"><label for="fname">First Name or Vendor Company</label></p>
						<p class="i"><input name="fname" type="text" value="<?=$fname?>" /></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="lname">Last Name</label></p>
						<p class="i"><input name="lname" type="text" value="<?=$lname?>" /></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="title">Job Title or Company Service</label></p>
						<p class="i"><input name="title" type="text" value="<?=$title?>" /></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="level">Access Level</label></p>
						<p class="i"><input name="level" type="text" value="<?=$level?>" /></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="current">Current Employee or Vendor</label></p>
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
				<fieldset>
					<legend>Mobile Phone (text enabled device)</legend>
					<p><?=$phoneStatus?></p>
					<div class="ques">
						<p class="l"><label for="phone">Phone Number</label></p>
						<p class="i"><input name="phone" type="text" value="<?=$phone?>" /> </p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="service">Phone Service</label></p>
						<p class="i">
							<select name="service" id="service">
								<option value="0"> </option>
								<?php
									$mob_sql="SELECT id,company,email FROM mobile ORDER BY company";
									$mob_result=mysql_query($mob_sql);
									while($row=mysql_fetch_assoc($mob_result)){
										$mob_id=$row['id'];
										$mob_comp=$row['company'];
										$mob_email=$row['email'];
										if($mob_id==$service){
											echo "<option value=\"".$mob_id."\" selected=\"selected\" >".$mob_comp."</option>";
										}else{
											echo "<option value=\"".$mob_id."\">".$mob_comp."</option>";
										}	
									}
								?>
							</select>
						</p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
				</fieldset>
				<fieldset>
					<legend>Login</legend>
					<p><?=$loginStatus?></p>
					<div class="ques">
						<p class="l"><label for="username">Username</label></p>
						<p class="i"><input name="username" type="text" value="<?=$username?>" /></p>
						<p class="e"><?=$userError?> </p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="password">Password</label></p>
						<p class="i"><input name="password" type="password" value="<?=$password?>" /></p>
						<p class="e"><?=$passerror?> </p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
				</fieldset>
				<div class="clearfloat"></div>
				<div class="ques btns">
					<input type="hidden" name="id" value="<?=$id?>" />
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