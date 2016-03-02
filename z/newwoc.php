<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_POST)){
	header ('Location: newwo.php');
}else{
	$error=false;
	$location=$_POST['location'];
	$b=$_POST['by'];
	$barr=preg_split('/-/',$b);
	$by=$barr[0];
	$resEmail=$barr[1];
	$byTable=substr($by,0,1);
	$byId=substr($by,1);
	$notify=$_POST['notify'];
	$enter=$_POST['enter'];
	$cat=$_POST['cat'];
	$status=$_POST['status'];
	$cdate=$_POST['completedate'];
	$sdate=$_POST['scheduleddate'];
	$t=$_POST['tech'];
	$tarr=preg_split('/-/',$t);
	$tech=$tarr[0];
	$techEmail=$tarr[1];
	$details=$_POST['details'];
	$onotes=$_POST['onotes'];
	$year=date('y',time());
	$wo_table="wo_".$year;
	$wo_req_table="wo_".$year."_req";
	$empId=$_SESSION['id'];
	if($details==""){$error=true;}
	if($error==false){
		$wsql="INSERT INTO $wo_table SET dateEntered=NOW(), locId=$location, empId=$empId, requestBy='$by', notify='$notify', enter='$enter'";
		if(mysql_query($wsql)){
			$lastInsertId=mysql_insert_id();
			$rsql="INSERT INTO $wo_req_table SET woId=$lastInsertId, itemNum=1, category=$cat, status=$status, detailRequest='$details', officeNote='$onotes', tech=$tech";
			if(mysql_query($rsql)){
				//send email to tech
				if($techEmail!=""){
					$locsql="SELECT locName FROM loc WHERE id=$location";
					$locresult=mysql_query($locsql);
					$locrow=mysql_fetch_array($locresult);
					$loc=$locrow['locName'];
					$subject="New Workorder";
					$headers="From: <management@hiddenpond.com>";
					$message.="wo# $year";
					$message.="$lastInsertId / ";
					$message.="Loc: $loc /";
					$message.="Request: $details\n";
					$tmail=@mail($techEmail, $subject, $message, $headers);
					if($tmail){
						if($notify=="on" && $resEmail!=""){
							//send email notification to resident
							$stsql="SELECT type FROM status WHERE id=$status";
							$stresult=mysql_query($stsql);
							$strow=mysql_fetch_array($stresult);
							$sta=$strow['type'];
							$subject="MyHome Workorder Request";
							$headers="From: \"MyHome Management\" <management@myhomeappartments.com>";
							$message="Thank you for your request. We have sent your request to our service department. Below is the summary of your request. You will receive another email when the status of your request changes.\n\n";
							$message.="Workorder# $year";
							$message.="$lastInsertId \n";
							$message.="Unit: $loc \n";
							$message.="Request: $details\n";
							$message.="Status: $sta";
							$rmail=@mail($resEmail, $subject, $message, $headers);
						}
					}else{
					}
				}
				header("Location: index.php");
			}
		}else{
			$formstatus="Your request has not been submitted";
		}
	}else{
		$formstatus="Please correct the fields below.";
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
		<ul id="nav"><!-- ====================== side button navigation -->
			<li><a href="index.php" id="open">home</a></li>
			<li><a href="newwo.php" id="new" class="active">new workorder</a></li>
			<li><a href="report.php" id="report">report</a></li>
		</ul><!-- #nav -->
		<div id="display"><!-- ========= location of all result content -->
			<h2 id="woh2">New Workorder</h2>
			<div class="clearfloat"></div>
			<p><?=$formstatus?></p>
			<form name="newwocheck" id="unitform" action="newwoc.php" method="post">
				<div id="wo">
					<div class="left">
<!-- unit ============================================================== -->
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
					</div><!-- .left -->
					<div class="right">
<!-- requested by ============================================================== -->
						<div class="ques">
							<p class="l"><label for="by">Requested By</label></p>
							<p class="i"><select name="by" id="by">
								<option value="none"> </option>
									<optgroup label="Residents">
									<?php
										$lsql="SELECT locType FROM loc WHERE id=$location";
										$lresult=mysql_query($lsql);
										$lrow=mysql_fetch_array($lresult);
										if($lrow['locType']=="unit"){
											$rsql="SELECT r.id, r.fName, r.lName, re.email 
													FROM resident AS r
													JOIN lease_resident AS lr ON (r.id=lr.residentId)
													JOIN lease AS l ON (l.id=lr.leaseId)
													JOIN r_email AS re ON (re.residentId=r.id)
													WHERE l.locId=$location
													ORDER BY r.fName";
											$rresult=mysql_query($rsql);
											while($rrow=mysql_fetch_assoc($rresult)){
												$rid=$rrow['id'];
												$rname=$rrow['fName']." ".$rrow['lName'];
												$remail=$rrow['email'];
												if($byTable=="R" && $rid==$byId){
													echo "<option value=\"R$rid-$remail\" selected=\"selected\">$rname</option>";
												}else{
													echo "<option value=\"R$rid-$remail\">$rname</option>";
												}
											}
										echo "</optgroup>";
										}
										echo "<optgroup label=\"Staff\">";
										$esql="SELECT id, fName, lName
												FROM employee
												WHERE NOT level='vendor'
												ORDER BY fName";
										$eresult=mysql_query($esql);
										while($erow=mysql_fetch_assoc($eresult)){
											$eid=$erow['id'];
											$ename=$erow['fName']." ".$erow['lName'];
											if($byTable=="E" && $eid==$byId){
												echo "<option value=\"E$eid\" selected=\"selected\">$ename</option>";
											}else{
												echo "<option value=\"E$eid\">$ename</option>";
											}
										}
									?>
									</optgroup>
								</select></p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques checks">
							<p id="notifyp"><label for="notify">Send Email Notification</label>
								<?php
									if($notify=='on'){
										echo "<span class=\"checks\"><input type=\"checkbox\" name=\"notify\" id=\"notify\" checked/></span>";
									}else{
										echo "<span class=\"checks\"><input type=\"checkbox\" name=\"notify\" id=\"notify\"/></span>";
									}
								?>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques checks">
							<p id="enterp"><label for="enter">Permission To Enter</label>
							<?php
								if($enter=='on'){
									echo "<span class=\"checks\"><input type=\"checkbox\" name=\"enter\" id=\"enter\" checked/></span>";
								}else{
									echo "<span class=\"checks\"><input type=\"checkbox\" name=\"enter\" id=\"enter\"/></span>";
								}
							?>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</div><!-- .right -->
				</div><!-- #wo -->
				<div class="clearfloat"></div>
				<div class="wo">
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
												if($cat==$catId){
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
								<p class="i">
									<select name="status" id="status">
										<?php
											$stats_sql="SELECT id,type FROM status ORDER BY type";
											$stats_result=mysql_query($stats_sql);
											while($row=mysql_fetch_assoc($stats_result)){
												$statsId=$row['id'];
												$statsType=$row['type'];
												if($status==$statsId){
													echo "<option value=\"$statsId\" selected=\"selected\" >$statsType</option>";
												}else{
													echo "<option value=\"$statsId\">$statsType</option>";
												}
											}
										?>
									</select>
								</p>
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
											if($tid==$tech){
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
								<p class="i"><textarea cols="40" rows="4" name="details" id="details"><?=$details?></textarea></p>
								<p class="e"></p>
								<div class="clearfloat"></div>
							</div><!-- .ques -->
							<div class="ques">
								<p class="l"><label for="onote">Office Notes</label></p>
								<p class="i"><textarea cols="40" rows="4" name="onote" id="onote"><?=$onote?></textarea></p>
								<p class="e"></p>
								<div class="clearfloat"></div>
							</div><!-- .ques -->
						</div><!-- .right -->
						<div class="clearfloat"></div>
					</fieldset>
				</div><!-- #wo -->
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