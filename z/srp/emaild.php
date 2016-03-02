<?php /*last update: 11/2010 */ ?>

<?php
require('../srp/protect.php');
require('requireddbcf.php');
if(empty($_GET)){
	('Location: ../index.php');
}else{
	$eId=$_GET['e'];
	$rId=$_GET['r'];
	$sql="DELETE FROM r_email WHERE id=$eId";
	mysql_query($sql);
	header("Location: ../residentm.php?r=$rId");
}
?>