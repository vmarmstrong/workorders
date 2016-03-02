<?php /*last update: 11/2010 */ ?>

<?php
require('../srp/protect.php');
require('../../../../db_tt.php');
if(empty($_GET)){
	('Location: ../index.php');
}else{
	$vId=$_GET['v'];
	$rId=$_GET['r'];
	$rvsql="DELETE FROM resident_vehicle WHERE vehicleId=$vId";
	if(mysql_query($rvsql)){
		$vsql="DELETE FROM vehicle WHERE id=$vId";
		mysql_query($vsql);
	}
	header("Location: ../residentm.php?r=$rId");
}
?>