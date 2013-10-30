<?php

//grab url information
//should be hostname of RPi
$image = $_GET["i"];

//find right image
switch($image):

	case "room-sign-101":
	$i = "room-sign-101.jpg"
	break;
	//specify default image
	default:
	$i = "/images/none.jpg";
	break;

?>
