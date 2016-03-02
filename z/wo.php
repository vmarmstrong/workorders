<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
if(empty($_POST)){
	if(empty($_GET)){
		header('Location: index.php');
	}else{
		$wo=$_GET['w'];
		//separate wo number into year, id, and tables to pull info from
		$year=substr($wo,0,2);
		$wtable="wo_".$year;
		$wreq_table="wo_".$year."_req";
		$wId=substr($wo,2);
		$wsql="SELECT w.dateEntered, l.locName, w.requestBy, w.notify, w.enter, e.fName, e.lName, wr.category, wr.status, wr.completeDate, wr.scheduleDate, wr.detailRequest, wr.officeNote, wr.serviceNote, wr.tech
			FROM $wtable as w
			JOIN loc as l ON (w.locId=l.id)
			JOIN employee AS e ON (w.empId=e.id)
			JOIN $wreq_table as wr ON (wr.woId=w.id)
			WHERE w.id=$wId";
		$wresult=mysql_query($wsql);
		$wrows=mysql_num_rows($wresult);
		if(!$wrows){
			//if there is no matching workorder id-send to index
			header('Location: index.php');
		}else{
			//if there is matching workorder id-pull info
			$wrow=mysql_fetch_assoc($wresult);
			$date=date('m/j/Y g:ia',strtotime($wrow['dateEntered']));
			$loc=$wrow['locName'];
			$by=$wrow['requestBy'];
			$byTable=substr($by,0,1);
			$byId=substr($by,1);
			$notify=$wrow['notify'];
			$enter=$wrow['enter'];
			$emp=$wrow['fName']." ".$wrow['lName'];
			$category=$wrow['category'];
			$status=$wrow['status'];
			$completeDate=date('m/j/Y g:ia',strtotime($wrow['completeDate']));
			$scheduleDate=$wrow['scheduleDate'];
			if($scheduleDate=="0000-00-00"){
				$scheduleDate="";
			}
			$detailRequest=$wrow['detailRequest'];
			$officeNote=$wrow['officeNote'];
			$serviceNote=$wrow['serviceNote'];
			$tech=$wrow['tech'];
		}
	}
}else{
	$errors=false;
	$sendemail=false;
	$statusChange=false;
	$wo=$_POST['wo'];
	$year=substr($wo,0,2);
	$wtable="wo_".$year;
	$wreq_table="wo_".$year."_req";
	$wId=substr($wo,2);
// pull original info to see if anything has changed
	$osql="SELECT w.dateEntered, l.locName, w.requestBy, w.notify, w.enter, e.fName, e.lName, wr.category, wr.status, wr.completeDate, wr.scheduleDate, wr.detailRequest, wr.officeNote, wr.serviceNote, wr.tech
			FROM $wtable as w
			JOIN loc as l ON (w.locId=l.id)
			JOIN employee AS e ON (w.empId=e.id)
			JOIN $wreq_table as wr ON (wr.woId=w.id)
			WHERE w.id=$wId";
	$oresult=mysql_query($osql);
	$orows=mysql_num_rows($oresult);
	$orow=mysql_fetch_assoc($oresult);
		$odate=$orow['dateEntered'];
		$oloc=$orow['locName'];
		$oby=$orow['requestBy'];
		$obyTable=substr($by,0,1);
		$obyId=substr($by,1);
		$onotify=$orow['notify'];
		$oenter=$orow['enter'];
		$oemp=$orow['fName']." ".$orow['lName'];
		$ocategory=$orow['category'];
		$ostatus=$orow['status'];
		$ocompleteDate=$orow['completeDate'];
		$oscheduleDate=$orow['scheduleDate'];
		$odetailRequest=$orow['detailRequest'];
		$oofficeNote=$orow['officeNote'];
		$oserviceNote=$orow['serviceNote'];
		$otech=$orow['tech'];
	$reqId=$_POST['reqId'];
	$date=$_POST['dateEntered'];
	$loc=$_POST['locName'];
	$by=$_POST['requestBy'];
	$byTable=substr($by,0,1);
	$byId=substr($by,1);
	$emp=$_POST['emp'];
	$notify=$_POST['notify'];
	$enter=$_POST['enter'];
	$category=$_POST['category'];
	$status=$_POST['status'];
	$scheduleDate=$_POST['scheduleDate'];
	if($scheduleDate=="0000-00-00"){
		$scheduleDate="";
	}
	$tech=$_POST['tech'];
	$detailRequest=$_POST['detailRequest'];
	$officeNote=$_POST['officeNote'];
	$serviceNote=$_POST['serviceNote'];
// if post status doesn't equal original status
	if($status==3 && $sdate=""){
		$sdateErr="Please enter date";
		$errors=true;
	}
	if($status==4 && $snotes=""){
		$snotesErr="Please enter details of work.";
		$errors=true;
	}
	if($errors==false){
		if($byTable=="R" && $notify=="on" && $status!=$ostatus){
			$ressql="SELECT email FROM r_email WHERE residentId=$byId";
			$resresult=mysql_query($ressql);
			$resrows=mysql_num_rows($resresult);
			if(!$resrows){
				echo "no res email<br>";
				$sendemail=false;
			}else{
				$resEmail=array();
				while($resrow=mysql_fetch_assoc($resresult)){
					$r=$resrow['email'];
					$resEmail[]=$r;
				}
				$resEmail=implode(", ", $resEmail);
				$sendemail=true;
			}
		}
		$updateWoSql="UPDATE $wtable SET notify='$notify', enter='$enter' WHERE id=$wId";
		if(mysql_query($updateWoSql)){
			if($status==4){
				$updateReqSql="UPDATE $wreq_table SET category=$category, status=$status, completeDate=NOW(), officeNote='$officeNote', tech=$tech, serviceNote='$serviceNote' WHERE woId=$wId";
			}else if($status==3){
				$updateReqSql="UPDATE $wreq_table SET category=$category, status=$status, scheduleDate=$scheduleDate, officeNote='$officeNote', tech=$tech WHERE woId=$wId";
			}else{
				$updateReqSql="UPDATE $wreq_table SET category=$category, status=$status, officeNote='$officeNote', tech=$tech WHERE woId=$wId";
			}
			if(mysql_query($updateReqSql)){
				if($sendemail==true){
					//send email notification to resident
					$stsql="SELECT type FROM status WHERE id=$status";
					$stresult=mysql_query($stsql);
					$strow=mysql_fetch_array($stresult);
					$sta=$strow['type'];
					$subject="MyHome Workorder Request";
					$headers="From: \"MyHome Management\" <management@myhomeappartments.com>";
					$message="The status of your service request has changed.  Below is the summary of your request.\n\n";
					$message.="Workorder# $wId \n";
					$message.="Unit: $loc \n";
					$message.="Request: $detailRequest\n";
					$message.="Status: $sta";
					
					$rmail=@mail($resEmail, $subject, $message, $headers);
				}
				header('Location: index.php');
			}
		}
	}else{
		header("Location: wo.php?w=$wo");
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
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
 	<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<!-- <script type="text/javascript"  src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/i18n/jquery-ui-i18n.min.js"></script> -->
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
			<h2>Workorder #<?=$wo?></h2>
			<p><?=$formstatus?></p>
			<form name="woform" action="wo.php" method="post" class="wo">
				<input type="hidden" name="wo" value="<?=$wo?>" />
				<div id="wo">
					<div class="left">
						<div class="ques">
							<p class="l"><label for="unit">Unit</label></p>
							<p class="i"><?=$loc?><input type="hidden" name="locName" value="<?=$loc?>" /></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="date">Submit Date</label></p>
							<p class="i"><?=$date?><input type="hidden" name="dateEntered" value="<?=$date?>" /></p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="emp">Entered By</label></p>
							<p class="i"><?=$emp?><input type="hidden" name="emp" value="<?=$emp?>" /></p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</div><!-- .left -->
					<div class="right">
						<div class="ques">
							<p class="l"><label for="by">Requested By</label></p>
							<p class="i">
								<?php
									if($byTable=="R"){
										$rsql="SELECT fName, lName FROM resident WHERE id=$byId";
										$rresult=mysql_query($rsql);
										$rrow=mysql_fetch_array($rresult);
										$rname=$rrow['fName']." ".$rrow['lName'];
										echo "$rname<input type=\"hidden\" name=\"requestBy\" value=\"$by\" />";
									}
									if($byTable=="E"){
										$esql="SELECT fName, lName FROM employee WHERE id=$byId";
										$eresult=mysql_query($esql);
										$erow=mysql_fetch_assoc($eresult);
										$ename=$erow['fName']." ".$erow['lName'];
										echo "$ename<input type=\"hidden\" name=\"requestBy\" value=\"$by\" />";
									}		
								?>
							</p>
							<p class="e"></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques checks">
							<p id="notifyp"><label for="notify">Send Email Notification</label> <span class="checks">
							<?php
								if($notify=="on"){
									echo "<input type=\"checkbox\" name=\"notify\" id=\"notify\" checked />";
								}else{
									echo "<input type=\"checkbox\" name=\"notify\" id=\"notify\" />";
								}
							?></span></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques checks">
							<p id="enterp"><label for="enter">Permission To Enter</label> <span class="checks">
							<?php
								if($enter=="on"){
									echo "<input type=\"checkbox\" name=\"enter\" id=\"enter\" checked />";
								}else{
									echo "<input type=\"checkbox\" name=\"enter\" id=\"enter\" />";
								}
							?></span></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</div><!-- .right -->
				</div><!-- #wo -->
				<div class="clearfloat"></div>
				<fieldset class="request">
					<legend>Request</legend>
					<div class="left">
						<div class="ques">
							<input type="hidden" name="reqId" value="<?=$reqId?>" />
							<p class="l"><label for="category">Category</label></p>
							<p class="i"><select name="category" id="category">
								<?php
									$csql="SELECT id, type
										FROM cats
										ORDER BY type";
									$cresult=mysql_query($csql);
									while($crow=mysql_fetch_assoc($cresult)){
										$cid=$crow['id'];
										$ctype=$crow['type'];
										if($cid==$category){
											echo "<option value=\"$cid\" selected=\"selected\" >$ctype</option>";
										}else{
											echo "<option value=\"$cid\">$ctype</option>";
										}
									}
								?>
								</select></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="status">Status</label></p>
							<p class="i"><select name="status" id="status">
								<?php
									$ssql="SELECT id, type
										FROM status
										ORDER BY id";
									$sresult=mysql_query($ssql);
									while($srow=mysql_fetch_assoc($sresult)){
										$sId=$srow['id'];
										$sType=$srow['type'];
										if($sId==$status){
											echo "<option value=\"$sId\" selected=\"selected\" >$sType</option>";
										}else{
											echo "<option value=\"$sId\">$sType</option>";
										}
									}
								?>
								</select></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					<?php if($status==4){ ?>
						<div class="ques">
							<p class="l"><label for="completeDate">Completed Date</label></p>
							<p class="i"><?=$completeDate?></p>
							<div class="clearfloat\"></div>
						</div><!-- .ques -->
					<?php } ?>
					<?php if($status==3){ ?>
						<div class="ques" id="sstatus">
							<p class="l"><label for="scheduleDate">Scheduled Date</label></p>
							<p class="i"><input type="text" name="scheduleDate" id="scheduleDate" class="hasDatepicker" value="<?=$scheduleDate?>" /></p>
							<p class="e"><?=$scheduleDateErr?></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					<?php }else{ ?>
						<div class="ques hidden" id="sstatus">
							<p class="l"><label for="scheduleDate">Scheduled Date</label></p>
							<p class="i"><input type="text" name="scheduleDate" id="scheduleDate" value="<?=$scheduleDate?>" /></p>
							<p class="e"><?=$scheduleDateErr?></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					<?php } ?>
						<div id="datepicker"></div>
						<div class="ques">
							<p class="l"><label for="tech">Service Tech</label></p>
							<p class="i"><select name="tech" id="tech">
								<optgroup label="Employees">
							<?php
								$tsql="SELECT id, fName, lName
										FROM employee
										WHERE level='service'
										ORDER BY fName";
								$tresult=mysql_query($tsql);
								while($trow=mysql_fetch_assoc($tresult)){
									$tid=$trow['id'];
									$tname=$trow['fName']." ".$trow['lName'];
									if($tid==$tech){
										echo "<option value=\"$tid\" selected=\"selected\" >$tname</option>";
									}else{
										echo "<option value=\"$tid\">$tname</option>";
									}
								}
								echo "</optgroup><optgroup label=\"Vendors\">";
								$vsql="SELECT id, fName, lName
										FROM employee
										WHERE level='vendor'
										ORDER BY fName";
								$vresult=mysql_query($vsql);
								while($vrow=mysql_fetch_assoc($vresult)){
									$vid=$vrow['id'];
									$vname=$vrow['fName']." ".$vrow['lName'];
									if($vid==$tech){
										echo "<option value=\"$vid\" selected=\"selected\" >$vname</option>";
									}else{
										echo "<option value=\"$vid\">$vname</option>";
									}
								}
							?>
							</optgroup></select></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					</div><!-- .left -->
					<div class="right">
						<div class="ques">
							<p class="l"><label for="detailRequest">Detailed Request (displayed in resident email)</label></p>
							<p class="i"><textarea cols="40" rows="4" name="detailRequest" id="detailRequest"><?=$detailRequest?></textarea></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
						<div class="ques">
							<p class="l"><label for="officeNote">Office Notes</label></p>
							<p class="i"><textarea cols="40" rows="4" name="officeNote" id="officeNote"><?=$officeNote?></textarea></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					<?php if($status==4){ ?>
						<div class="ques"  id="cstatus">
							<p class="l"><label for="serviceNote">Work done (displayed in resident email)</label></p>
							<p class="i"><textarea cols="40" rows="4" name="serviceNote" id="serviceNote"><?=$serviceNote?></textarea></p>
							<p class="e"><?=$serviceNoteErr?></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					<?php }else{ ?>
						<div class="ques hidden" id="cstatus">
							<p class="l"><label for="serviceNote">Work done (displayed in resident email)</label></p>
							<p class="i"><textarea cols="40" rows="4" name="serviceNote" id="serviceNote"><?=$serviceNote?></textarea></p>
							<p class="e"><?=$serviceNoteErr?></p>
							<div class="clearfloat"></div>
						</div><!-- .ques -->
					<?php } ?>
					</div><!-- .right -->
					<div class="clearfloat"></div>
				</fieldset>
				<p>
					<input type="hidden" name="wo" value="<?=$wo?>" />
					<input class="submitbtn" type="submit" name="submit" value="Update" /> <span class="printlink"><a target="_blank" href="printwo.php?w=<?=$wo?>" title="print workorder">Print</a></span> <span class="secondlink"><a href="index.php" title="Cancel and return home">Cancel</a></span>
				</p>
			</form>
		</div><!-- #display -->
	</div><!-- #content -->
	<div class="clearfloat"></div>
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<?php include('srp/bgbot.php') ?>
</body>
</html>