<?php /*last update: 11/2010 */ ?>

<?php
if(!isset($_SESSION)){
	session_start();
	session_regenerate_id();
}
if(empty($_POST)){
	$status="Please log in.";
}else{
	require('srp/requiredb.php');
	if($_POST['username']!='Username' || $_POST['password']!='Password'){
		$username=htmlentities(strip_tags(mysql_real_escape_string($_POST['username'])));
		$password=md5($_POST['password']);
		$sql="SELECT id, fName, lName, level
				FROM employee
				WHERE username='$username' AND password='$password'";
		$result=mysql_query($sql);
		$row=mysql_fetch_assoc($result);
		if(mysql_num_rows($result)>0){
			session_start();
			session_regenerate_id();
			$_SESSION['logged_in']=true;
			$_SESSION['id']=$row['id'];
			$_SESSION['fName']=$row['fName'];
			$_SESSION['lName']=$row['lName'];
			$_SESSION['level']=$row['level'];
			$_SESSION['pass']=$password;
			header('Location: z/index.php');
		}else{
			$status = "Invalid user or password information.";
		}
	}else{
		$status = "Please enter your user and password.";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>TimelyTask: Workorder System</title>
	<!-- <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" /> -->
	<!--[if lte IE 7]>
	    <link rel="shortcut icon" href="/favicon.ico" /><link rel="icon" type="image/ico" href="/favicon.ico" />
	<![endif]-->
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
		<div id="logo"><h1><a href="index.php" title="Return to TimelyTask Landing Page">timelyTask</a></h1></div>
		<div id="loginform">
		<?php
			if($_SESSION['logged_in']==true){
				echo "<p><a href=\"z/index.php\" title=\"Return to your TimelyTask account\">Welcome back, ".$_SESSION['fName'].".</a></p>";
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
		<div id="idisplay" class="main"><!-- Location of all result content -->
			<!-- <h2>Make your workorder work for you.</h2> -->
			<div id="cta">
				<p id="action"><a href="contact.php" title="Get your account today!">Get your account today!</a></p>
				<div class="clearfloat"></div>
			</div><!-- #cta -->
			<?php include('srp/benefits.php'); ?>
		</div><!-- #indexdisplay -->
	</div><!-- #content -->
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php'); ?>

</body>
</html>