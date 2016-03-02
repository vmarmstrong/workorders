<?php /*last update: 11/2010 */ ?>

<?php
require('protect.php');
require('../../../../../../db_tt.php');
$locId=$_GET['loc'];
?>
<select name="by" id="by">
<option value="none"> </option>
	<optgroup label="Residents">
	<?php
		$lsql="SELECT locType FROM loc WHERE id=$locId";
		$lresult=mysql_query($lsql);
		$lrow=mysql_fetch_array($lresult);
		if($lrow['locType']=="unit"){
			$rsql="SELECT r.id, r.fName, r.lName, re.email 
					FROM resident AS r
					JOIN lease_resident AS lr ON (r.id=lr.residentId)
					JOIN lease AS l ON (l.id=lr.leaseId)
					JOIN r_email AS re ON (re.residentId=r.id)
					WHERE l.locId=$locId
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
</select>