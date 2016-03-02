<?php /*last update: 11/2010 */ ?>

<?php
require('protect.php');
require('../../../../../../db_tt.php');
?>
<option value="none"> </option>
<?php
	$sql="SELECT id, locName FROM loc ORDER BY locType, locName";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$id=$row['id'];
		$locName=$row['locName'];
		echo "<option value=\"$id\">$locName</option>";
	}
?>