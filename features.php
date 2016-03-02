<?php /*last update: 11/2010 */ ?>

<?php
if(!isset($_SESSION)){
	session_start();
	session_regenerate_id();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>TimelyTask: Workorder System</title>
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
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
		<div id="idisplay" class="main"><!-- Location of all result content -->
			<h2>Features</h2>
			<div class="benefits">
				<h4>Hosted Service</h4>
				<p>Our web application allows you full access without needing to purchase additional software licenses or additional computer hardware.  Access our application from any internet connected computer or mobile device.</p>
			</div><!-- .benefits -->
			<div class="benefits">
				<h4>Search</h4>
				<p>Our system archives all your data allowing you full search capabilities. Search for workorders, residents, units, or even vehicle tag numbers.</p>
			</div><!-- .benefits -->
			<div class="benefits">
				<h4>Auto Dispatching</h4>
				<p>Enter your service tech's phone number and have workorders dispatched directly to their phone as soon as you submit a request.</p>
			</div><!-- .benefits -->
			<div class="benefits">
				<h4>Automatically Updated Residents</h4>
				<p>Update your residents automatically whenever a status has changed.</p>
			</div><!-- .benefits -->
			<div class="benefits">
				<h4>View Resident History</h4>
				<p>TimelyTask allows you to view all service requests in any unit on your property</p>
			</div><!-- .benefits -->
			<div class="benefits">
				<h4>Easy to Use</h4>
				<p>We've all used difficult products at some point, but with timelyTask's design and layout your work is a breeze.</p>
			</div><!-- .benefits -->
			<div class="benefits">
				<h4>Access Control</h4>
				<p>As an administrator you will have access to update and change anything however you may need to restrict access to others based on the sensitivity of the information.  By setting access levels enables you to control what information your team sees.</p>
			</div><!-- .benefits -->
			<div class="clearfloat"></div>
		</div><!-- #display -->
		<div class="clearfloat"></div>
	</div><!-- #content -->
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php'); ?>

</body>
</html>