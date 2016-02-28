<?php
session_start();

	header("Content-type: image/png");
	
	$img = imagecreate (55,18) or die ("Problème de création GD");
	$background_color = imagecolorallocate ($img, 175, 13, 33);
	$ecriture_color = imagecolorallocate($img, 255, 255, 255);
	imagestring ($img, 20, 4, 0, $_SESSION['captcha'] , $ecriture_color);
	imagepng($img);

?>
