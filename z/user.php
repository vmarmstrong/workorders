<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_POST)){
	$id=$_SESSION['id'];
	$sql="SELECT * FROM employee WHERE id='$id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_assoc($result);
	$fname=$row['fName'];
	$lname=$row['lName'];
	$title=$row['title'];	
	$level=$row['level'];
	$phone=$row['phone'];
	$service=$row['service'];
	$username=$row['username'];
}else{
	$error=false;
	$id=$_POST['id'];
	$fname=$_POST['fname'];
	$lName=$_POST['lname'];
	$title=$_POST['title'];
	$level=$_POST['level'];
	$phone=$_POST['phone'];
	$service=$_POST['service'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$repassword=$_POST['repassword'];
	if($password != $repassword){
		$repassError= "The passwords did not match. Please try again.";
		$error=true;
	}
	$csql="SELECT * FROM employee WHERE username='$username' AND id!=$id";
	$cresult=mysql_query($csql);
	if(mysql_num_rows($cresult)>=1){
		$userError="That username is unavailable.";
		$error=true;
	}
	
	if($error==false){
		$pass=md5($password);
		
		$sql ="UPDATE employee SET phone='$phone', service='$service', username='$username', password='$pass' WHERE id =$id";
		if(mysql_query($sql)){
			$formstatus="Your profile has been updated.";
		}else{
			$formstatus="Your profile has not been updated.";
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
			<h2>My Profile</h2>
			<p><?=$formstatus?></p>
			<form action="user.php" method="post" class="user">
				<fieldset>
					<legend>User</legend>
					<div class="ques">
						<p class="l"><label>Name</label></p>
						<p class="i"><?=$fname?> <?=$lname?></p>
						<input type="hidden" name="fname" value="<?=$fname?>" />
						<input type="hidden" name="lname" value="<?=$lname?>" />
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label>Title</label></p>
						<p class="i"><?=$title?></p>
						<input type="hidden" name="title" value="<?=$title?>" />
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label>Access Level</label></p>
						<p class="i"><?=$level?></p>
						<input type="hidden" name="level" value="<?=$level?>" />
						<div class="clearfloat"></div>
					</div><!-- .ques -->
				</fieldset>
				<fieldset>
					<legend>Mobile Phone (text enabled for receiving workorder requests)</legend>
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
						<p class="e"><?=$userError?></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="password">Password</label></p>
						<p class="i"><input name="password" type="password" value="<?=$password?>" /></p>
						<p class="e"><?=$cpasserror?> </p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="repassword">Re-enter Password</label></p>
						<p class="i"><input name="repassword" type="password" value="<?=$repassword?>" /></p>
						<p class="e"><?=$repassError?> </p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
				</fieldset>
				<div class="clearfloat"></div>
				<div class="ques btns">
					<input type="hidden" name="id" value="<?=$id?>" />
					<input class="submitbtn" type="submit" name="submit" value="Submit" /> <span class="secondlink"><a href="index.php">Cancel</a></span>
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