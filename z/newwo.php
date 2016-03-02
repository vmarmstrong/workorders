<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_POST)){
}else{
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
		<ul id="nav"><!-- ====================== side button navigation -->
			<li><a href="index.php" id="open">home</a></li>
			<li><a id="new" class="active">new workorder</a></li>
			<li><a href="report.php" id="report">report</a></li>
		</ul><!-- #nav -->
		<div id="display"><!-- ========= location of all result content -->
			<h2 id="ltPgHead">New Workorder</h2>
			<ul id="rtPgHeadList">
				<li><span id="s1" class="active">Step 1: Enter Unit Number</span></li>
				<li><span id="s2" class="future">Step 2: Choose Resident</span></li>
				<li><span id="s3" class="future">Step 3: Submit Request</span></li>
			</ul>
			<div class="clearfloat"></div>
			<div id="wo">
				<div class="left">
<!-- enter unit ============================================================== -->
				<form name="unitform" id="unitform" action="" method="post" class="wo">
					<h3>Select Location</h3>
					<div class="ques">
						<p class="l"><label for="location">Location</label></p>
						<p class="i">
							<select name="location" id="location">
								<option value="none"> </option>
								<?php
									$lsql="SELECT id, locName FROM loc ORDER BY locType, locName";
									$lresult=mysql_query($lsql);
									while($lrow=mysql_fetch_assoc($lresult)){
										$lid=$lrow['id'];
										$locName=$lrow['locName'];
										if($location==$lid){
											echo "<option value=\"$lid\" selected=\"selected\">$locName</option>";
										}else{
											echo "<option value=\"$lid\">$locName</option>";
										}
									}
								?>
							</select>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
				</form>
			</div><!-- .left -->
			<div class="right">
<!-- ============================================================== requested by form -->
				<form name="requestByform" id="requestByform" action="" method="post" class="wo hidden">
					<h3>Select Resident</h3>
					<div class="ques">
						<p class="l"><label for="by">Requested By</label></p>
						<p class="i"></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques checks">
						<p id="notifyp"><label for="notify">Send Email Notification</label>
							<span class="checks"><input type="checkbox" name="notify" id="notify"/></span></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
					<div class="ques checks">
						<p id="enterp"><label for="enter">Permission To Enter</label>
							<span class="checks"><input type="checkbox" name="enter" id="enter"/></span></p>
						<div class="clearfloat"></div>
					</div><!-- .ques -->
				</form>
			</div><!-- .right -->
		</div><!-- #wo -->
		<div class="clearfloat"></div>
<!-- ============================================================== request form -->
			<form name="requestform" id="requestform" action="newwoc.php" method="post" class="wo hidden">
				<div class="hidden" id="hiddenfields"></div>
				<fieldset class="request">
					<legend>Request</legend>
					<div class="left">
						<div class="ques">
							<p class="l"><label for="cat">Category</label></p>
							<p class="i">
								<select name="cat" id="cat">
									<?php
										$cats_sql="SELECT id,type FROM cats ORDER BY type";
										$cats_result=mysql_query($cats_sql);
										while($row=mysql_fetch_assoc($cats_result)){
											$catId=$row['id'];
											$catType=$row['type'];
											if($catId==1){
												echo "<option value=\"$catId\" selected=\"selected\" >$catType</option>";
											}else{
												echo "<option value=\"$catId\">$catType</option>";
											}
										}
									?>
								</select>
							</p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="status">Status</label></p>
							<p class="i">Pending<input type="hidden" name="status" value="1" /></p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="tech">Service Tech</label></p>
							<p class="i">
								<select name="tech" id="tech">
									<optgroup label="Employees">
									<?php
									$tsql="SELECT e.id, e.fName, e.lName, e.phone, m.email FROM employee AS e JOIN mobile AS m ON (e.service=m.id) WHERE level='service' ORDER BY fName";
									$tresult=mysql_query($tsql);
									while($trow=mysql_fetch_assoc($tresult)){
										$tid=$trow['id'];
										$tname=$trow['fName']." ".$trow['lName'];
										$temail=$trow['phone']."@".$trow['email'];
										if($tid==1){
											echo "<option value=\"$tid-$temail\" selected=\"selected\" >$tname</option>";
										}else{
											echo "<option value=\"$tid-$temail\">$tname</option>";
										}
									}
									echo "</optgroup>
										<optgroup label=\"Vendors\">";
										$vsql="SELECT id, fName, lName FROM employee WHERE level='vendor' ORDER BY fName";
										$vresult=mysql_query($vsql);
										while($vrow=mysql_fetch_assoc($vresult)){
											$vid=$vrow['id'];
											$vname=$vrow['fName']." ".$vrow['lName'];
											$vtitle=$vrow['title'];
											if($vid==$tech){
												echo "<option value=\"$vid\" selected=\"selected\" >$vname</option>";
											}else{
												echo "<option value=\"$vid\">$vname</option>";
											}
										}
									?>
								</select>
							</p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</div><!-- .left -->
					<div class="right">
						<div class="ques">
							<p class="l"><label for="details">Detailed Request (displayed in resident email)</label></p>
							<p class="i"><textarea cols="40" rows="4" name="details" id="details"></textarea></p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="onote">Office Notes</label></p>
							<p class="i"><textarea cols="40" rows="4" name="onote" id="onote"></textarea></p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</div><!-- .right -->
					<div class="clearfloat"></div>
				</fieldset>
				<p><input id="formsbtn" class="submitbtn" type="submit" name="submit" value="Submit" /> <span class="secondlink"><a href="index.php">Cancel</a></span></p>
			</form>
		</div><!-- #display -->
	</div><!-- #content -->
	<div class="clearfloat"></div>
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php')?>
</body>
</html>