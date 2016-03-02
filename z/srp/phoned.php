<?php /*last update: 11/2010 */ ?>

<?php
require('../srp/protect.php');
require('../../../../../db_tt.php');
if(empty($_GET)){
	('Location: ../index.php');
}else{
	$pId=$_GET['p'];
	$rId=$_GET['r'];
	$psql="DELETE FROM r_phone WHERE id=$pId";
	mysql_query($psql);
	header("Location: ../residentm.php?r=$rId");
}
?>