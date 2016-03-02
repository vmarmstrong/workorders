<?php /*last update: 11/2010 */ ?>

<?php
require('protect.php');
require('../../../../db_tt.php');
if(empty($_POST)){
	header('Location: index.php');
}else{
	$key=$_POST['key'];
	$page=$_POST['page'];
	if($page=='w'){
		if(is_numeric($key)){
			//separate wo number into year, id, and tables to pull info from
			$year=substr($key,0,2);
			$wo_table="wo_".$year;
			$wo_id=substr($key,2);
			$wsql="SELECT dateEntered FROM $wo_table where id=$wo_id";
			$wresult=mysql_query($wsql);
			if(mysql_num_rows($wresult)){
				header("Location: ../wo.php?w=$key");
			}else{
				header("Location: ../results.php?k=$key");
			}
		}else{
			header("Location: ../results.php?k=$key");
		}
	}
	if($page=='u'){
		$loc=strtoupper($key);
		$usql="SELECT id FROM loc WHERE locName='$loc'";
		$uresult=mysql_query($usql);
		if($urow=mysql_fetch_assoc($uresult) > 0){
			header("Location: ../unit.php?u=$key");
		}else{
			header("Location: ../results.php?k=$key");
		}
	}
	if($page=='r'){
		header("Location: ../results.php?k=$key");
	}
	if($page=='v'){
		$vtagsql="SELECT rv.residentId FROM vehicle as v JOIN resident_vehicle as rv ON(v.id=rv.vehicleId) WHERE v.tag='$key'";
		$vtagresult=mysql_query($vtagsql);
		if($vtagrow=mysql_fetch_assoc($vtagresult)==1){
			$rid=$vtagrow['residentId'];
			header("Location: ../residentm.php?r=$rid");
		}else{
			header("Location: ../results.php?k=$key");
		}
	}
}
?>