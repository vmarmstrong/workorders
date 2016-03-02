<?php /*last update: 11/2010 */ ?>

<?php
require('srp/protect.php');
require('srp/requiredb.php');
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
		$scheduleDate=date('m/j/Y g:ia',strtotime($wrow['scheduleDate']));
		$detailRequest=$wrow['detailRequest'];
		$officeNote=$wrow['officeNote'];
		$serviceNote=$wrow['serviceNote'];
		$tech=$wrow['tech'];
	}
	$today=date('m/j/Y g:ia',time());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>TimelyTask: Workorder System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="../css/print.css" />
	<?php include('../meta.php'); ?>
	<?php include('../analytics.php'); ?>
</head>
<body>
<!-- ============================================================== TOP -->
<div id="bgtop">
	<div class="left">
		<h1>timelyTask</h1>
	</div>
	<div class="right">
		<h3>MyHome Apartments</h3>
		<p>Printed: <?=$today?></p>
	</div>
	<div class="clearfloat"></div>
</div>
<!-- =========================================================== MIDDLE -->
<div id="bgmid">
	<h2>Workorder #<?=$wo?></h2>
	<div id="wo">
		<div class="ques first">
			<p class="l"><label>Unit</label></p>
			<p class="i"><?=$loc?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label>Submit Date</label></p>
			<p class="i"><?=$date?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label>Entered By</label></p>
			<p class="i"><?=$emp?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label>Requested By</label></p>
			<p class="i">
				<?php
					if($byTable=="R"){
						$rsql="SELECT fName, lName FROM resident WHERE id=$byId";
						$rresult=mysql_query($rsql);
						$rrow=mysql_fetch_array($rresult);
						$rname=$rrow['fName']." ".$rrow['lName'];
						echo "$rname";
					}
					if($byTable=="E"){
						$esql="SELECT fName, lName FROM employee WHERE id=$byId";
						$eresult=mysql_query($esql);
						$erow=mysql_fetch_assoc($eresult);
						$ename=$erow['fName']." ".$erow['lName'];
						echo "$ename";
					}		
				?>
			</p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label>Send Email Notification</label>
			<p class="i">
			<?php
				if($notify=="on"){
					echo "Yes";
				}else{
					echo "No";
				}
			?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label>Permission To Enter</label> 
			<p class="i">
			<?php
				if($enter=="on"){
					echo "Yes";
				}else{
					echo "No";
				}
			?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	</div><!-- #wo -->
	<div id="request">
		<div class="ques">
			<p class="l"><label>Category</label></p>
			<p class="i">
				<?php
					$csql="SELECT id, type FROM cats ORDER BY type";
					$cresult=mysql_query($csql);
					while($crow=mysql_fetch_assoc($cresult)){
						$cid=$crow['id'];
						$ctype=$crow['type'];
						if($cid==$category){
							echo "$ctype";
						}
					}
				?>
			</p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label>Status</label></p>
			<p class="i">
				<?php
					$ssql="SELECT id, type FROM status ORDER BY id";
					$sresult=mysql_query($ssql);
					while($srow=mysql_fetch_assoc($sresult)){
						$sId=$srow['id'];
						$sType=$srow['type'];
						if($sId==$status){
							echo "$sType";
						}
					}
				?>
			</p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	<?php if($status==4){ ?>
		<div class="ques">
			<p class="l"><label>Completed Date</label></p>
			<p class="i"><?=$completeDate?></p>
			<div class="clearfloat\"></div>
		</div><!-- .ques -->
	<?php } ?>
	<?php if($status==3){ ?>
		<div class="ques">
			<p class="l"><label>Scheduled Date</label></p>
			<p class="i"><?=$scheduleDate?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	<?php } ?>
		<div class="ques">
			<p class="l"><label>Service Tech</label></p>
			<p class="i">
			<?php
				$tsql="SELECT id, fName, lName FROM employee WHERE level='service' ORDER BY fName";
				$tresult=mysql_query($tsql);
				while($trow=mysql_fetch_assoc($tresult)){
					$tid=$trow['id'];
					$tname=$trow['fName']." ".$trow['lName'];
					if($tid==$tech){
						echo "$tname";
					}
				}
				$vsql="SELECT id, fName, lName FROM employee WHERE level='vendor' ORDER BY fName";
				$vresult=mysql_query($vsql);
				while($vrow=mysql_fetch_assoc($vresult)){
					$vid=$vrow['id'];
					$vname=$vrow['fName']." ".$vrow['lName'];
					if($vid==$tech){
						echo "$vname";
					}
				}
			?>
			</p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
		<div class="ques">
			<p class="l"><label>Detailed Request</label></p>
			<p class="i"><?=$detailRequest?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	<?php if($status==4){ ?>
		<div class="ques">
			<p class="l"><label>Work done (displayed in resident email)</label></p>
			<p class="i"><?=$serviceNote?></p>
			<div class="clearfloat"></div>
		</div><!-- .ques -->
	<?php } ?>
	</div><!-- #request -->
</div><!-- #bgmid -->
<!-- =========================================================== BOTTOM -->
<div id="bgbot">
	<div id="copyright">&#169 2010 <a href="http://vmcnichol.com">vmcnichol.com</a></div><!-- #copyright -->
</div><!-- #bgbot -->
</body>
</html>