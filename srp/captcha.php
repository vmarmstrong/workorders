<?php /*last update: 11/2010 */ ?>

<?php
	session_start();
	session_regenerate_id();
	$width=175;
	$height=35;
	$length=6;
	$baselist="246789wertyuadfhjkzxcvbnm";
	$img=imagecreate($width,$height);
	for($i=0;$i<10;$i++){
		$color=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
		imageline($img,rand(0,$width),rand(0,$height),rand(0,$width),rand(0,$height),$color);
	}
	for($i=0;$i<$length;$i++){
		$randchar=substr($baselist,rand(0,strlen($baselist)-1),1);
		$x+=18+rand(0,10);
		$color=imagecolorallocate($img,rand(0,100),rand(0,100),rand(0,100));
		imagechar($img,rand(3,5),$x,rand(5,15),$randchar,$color);
		$code.=$randchar;
	}
	header('Content-Type: image/png');
	imagepng($img);
	imagedestroy($img);
	$_SESSION['captcha']=$code;	
?>