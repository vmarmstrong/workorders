<?php /*last update: 11/2010 */ ?>

<?php
require('protect.php');
require('../../../../../../db_tt.php');
?>
<option value="none"> </option>
<?php
	$sql="SELECT id, type FROM status";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$id=$row['id'];
		$type=$row['type'];
		echo "<option value=\"$id\">$type</option>";
	}
?>