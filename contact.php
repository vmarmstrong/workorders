<?php /*last update: 11/2010 */ ?>

<?php
	session_start();
	require('srp/requiredb.php');
$status="Please log in.";
if(empty($_POST)){
	$formStatus="Submit this form to receive your personalized quote.";
	$displayForm=true;
}else{
	$displayError=false;
	$displayForm=true;
	if($_SESSION['captcha']==$_POST['captcha']){
		$subject="Apartment App";
		$to="vmcnichol@gmail.com";
		$name=$_POST['name'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$comp=$_POST['comp'];
		$city=$_POST['city'];
		$state=$_POST['state'];
		$units=$_POST['units'];
		if(empty($name)){$nameError="Please enter your name."; $displayError=true;}
		if(empty($email)){$emailError="Please enter your email."; $displayError=true;}
		if(empty($phone)){$phoneError="Please enter your phone number."; $displayError=true;}
		if($state=="none"){$state="";}
		if($displayError!=true){
			//send email
			$headers="From: \"$name\" <$email>";
			$message="Name: $name\n";
			$message.="Email: $email\n";
			$message.="Phone: $phone\n";
			$message.="Company: $comp\n";
			$message.="City: $city\n";
			$message.="State: $state\n";
			$message.="Number of units: $units\n";
			$mail=@mail($to, $subject, $message, $headers);
			if($mail){
				$formStatus="Thank you for your inquery.";
				$displayForm=false;
			}else{
				$formStatus="Your form could not be sent.";
				$displayForm=true;
			}
		}else{
			$formStatus="Please correct the fields below.";
			$displayForm=true;
		}
		$formStatus="Thank you for your inquery.";
		$displayForm=false;
	}else{
		//captcha error
		$formStatus="The verification did not match. Please try again.";
		$displayForm=true;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>TimelyTask: Workorder System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/vm.js"></script>
	<?php include('meta.php'); ?>
	<?php include('analytics.php'); ?>
</head>
<body>
<!-- ============================================================== TOP -->
<div id="bgtop">
	<div id="header">
		<div id="logo"><h1><a href="index.php">timelyTask</a></h1></div>
		<div id="loginform">
		<?php
			if($_SESSION['logged_in']==true){
				echo "<p><a href=\"z/index.php\">Welcome back, ".$_SESSION['fName'].".</a></p>";
				echo "<p id=\"loginstatus\">If you are not ".$_SESSION['fName'].", please <a href=\"z/srp/logout.php\" title=\"Login\">log in</a> now.</p>";
			}else{
				include('srp/loginform.php');
			}
		?>
		</div><!-- #loginform -->
	</div><!-- #header -->
	<div class="clearfloat"></div>
</div><!-- #bgtop -->
<!-- =========================================================== MIDDLE -->
<div id="bgmid">
	<div id="content">
		<div id="cdisplay" class="main"><!-- Location of all result content -->
			<div id="cdirections">
				<p><?=$formStatus?></p>
			</div><!-- #cdirections -->
			<?php if($displayForm==true){ ?>
			<form action="contact.php" method="post" class="contact">
				<fieldset>
					<legend>Required Information</legend>
					<div class="ques">
						<p class="l"><label for="name">* Name</label></p>
						<p class="i"><input name="name" type="text" value="<?=$name?>" /></p>
						<p class="e"><?=$nameError?></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="email">* Email</label></p>
						<p class="i"><input name="email" type="text" value="<?=$email?>" /></p>
						<p class="e"><?=$emailError?></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="phone">* Phone Number</label></p>
						<p class="i"><input name="phone" type="text" value="<?=$phone?>" /></p>
						<p class="e"><?=$phoneError?></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="captcha"><abbr title="Captcha images are used to decrease the amount of spam sent from automatic programs such as spambots and other kinds of automatic tools.">Please verify you are not a computer</abbr></label></dt>
						<p><img src="srp/captcha.php" /></p>
						<p class="i"><input type="text" name="captcha" id="captcha" value="<?=$captcha?>" /></dd>
					<p class="e"><?=$captchaError?></p>
					</div><!-- .ques -->
				</fieldset>
				<fieldset>
					<legend>Optional Information</legend>
					<div class="ques">
						<p class="l"><label for="comp">Company Name</label></p>
						<p class="i"><input name="comp" type="text" value="<?=$comp?>" /></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="city">City</label></p>
						<p class="i"><input name="city" type="text" value="<?=$city?>" /></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">
						<p class="l"><label for="state">State</label></p>
						<p class="i">
							<select name="state">
								<option value="none"> </option>
								<?php
									$ssql="SELECT * FROM state ORDER BY id";
									$sresult=mysql_query($ssql);
									while($srow=mysql_fetch_assoc($sresult)){
										$sabbr=$srow['abr'];
										$sname=$srow['name'];
										if($state==$sabbr){
											echo "<option value=\"$sabbr\" selected=\"selected\">$sname</option>";
										}else{
											echo "<option value=\"$sabbr\">$sname</option>";
										}
									}
								?></select></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques">		
						<p class="l"><label for="units">Number of units at your property</label></p>
						<p class="i"><input name="units" type="text" value="<?=$units?>" /></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
				</fieldset>
				<div class="clearfloat"></div>
				<div class="ques btns">
					<input class="submitbtn" type="submit" name="submit" value="Submit" /> <span class="secondlink"><a href="index.php">Cancel</a></span>
				</div><!-- .ques -->
			</form>
			<?php }
				if($displayForm==false){ 
					include('srp/benefits.php');
			 	}
			 ?>
		</div><!-- #cdisplay -->
	</div><!-- #content -->
	<div class="clearfloat"></div>
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php'); ?>

</body>
</html>