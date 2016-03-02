<?php /*last update: 11/2010 */ ?>

<?php
	if(!isset($_SESSION)){
		session_start();
		session_regenerate_id();
	}
	if($_SESSION['logged_in']!=true){
		header('Location: ../index.php');
	}
?>