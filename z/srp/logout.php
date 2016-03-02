<?php /*last update: 11/2010 */ ?>

<?php
session_start();
$_SESSION['logged_in']=false;
session_unset();
session_destroy();
header('Location: ../index.php');
?>