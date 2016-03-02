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
			<h2>Pricing</h2>
			<h3>Standard Package</h3>
			<table summary="This table is a summary the pricing plans.">
				<thead>
					<tr>
						<th></th>
						<th>Under 50 Units</th>
						<th>51-199 Units</th>
						<th>200-300 Units</th>
						<th>Over 300 Units</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Standard Service<br>(per month)</td>
						<td>$49</td>
						<td>$69</td>
						<td>$99</td>
						<td>Call for pricing</td>
					</tr>					
					<tr>
						<td>Setup Fee<br>(one time payment)</td>
						<td>$99</td>
						<td>$149</td>
						<td>$199</td>
						<td>Call for pricing</td>
					</tr>
				</tbody>
			</table>
			<h3>Additional Options</h3>
			<table summary="This table is a summary the additional options.">
				<thead>
					<tr>
						<th></th>
						<th>Under 50 Units</th>
						<th>51-199 Units</th>
						<th>200-300 Units</th>
						<th>Over 300 Units</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Resident Portal<br>(per month)</td>
						<td>$69</td>
						<td>$99</td>
						<td>$129</td>
						<td>Call for pricing</td>
					</tr>
					<tr>
						<td>Resident Portal Setup Fee<br>(one time payment)</td>
						<td>$99</td>
						<td>$149</td>
						<td>$199</td>
						<td>Call for pricing</td>
					</tr>
					<tr>
						<td>Additional Database<br>Customization</td>
						<td>Starting at $100</td>
						<td>Starting at $100</td>
						<td>Starting at $100</td>
						<td>Starting at $100</td>
					</tr>
				</tbody>
			</table>
		</div><!-- #indexdisplay -->
	</div><!-- #content -->
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<div id="bgbot">
	<div id="footer">
		<div id="copyright">&#169 2010 <a href="http://vmcnichol.com">vmcnichol.com</a> | <a href="contact.php">Contact Us</a> | <a href="http://www.linkedin.com/in/vmcnichol">Linked in</a></div><!-- #copyright -->
		<div id="acctlink"><p><a href="index.php">Benefits</a> | <a href="contact.php">Get Your Account Today!</a> | <a href="http://www.facebook.com/pages/TimelyTask/172889979390276">TimelyTask On Facebook</a></p></div><!-- #acctlink -->
	</div><!-- #footer -->
</div><!-- #bgbot -->
</body>
</html>