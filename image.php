<?php
/*
 * This file is intended to serve the right image.
 *
 *
 */
// Set the content type header - in this case image/jpeg
header('Content-Type: image/jpeg');
require('rooms.php');

if (isset($_GET["g"])) { $group = "/images/" . $_GET["g"] . ".jpg"; }
$i = NULL;

//grab url information
//should be hostname of RPi via puppet or any other URI

foreach ($rooms as $r) {
	foreach ($r['rpi'] as $h) {

		if ($_GET["i"] == $h) {
			$i = TRUE;
			break;
		}
	}
	//end the foreach when hostname/rpi is found
	if (!is_null($i)) { $image = "/images/" . $r['name'] . ".jpg"; break; }
}

//find right image in directory
if (file_exists($image)) {

	// open the file in a binary mode
	$fp = fopen($image, 'rb');

	// send the right headers
	header("Content-Length: " . filesize($image));

	// dump the picture and stop the script
	fpassthru($fp);
	exit;

} else if (file_exists($group) && isset($_GET["g"])) {

	// open the file in a binary mode
	$fp = fopen($group, 'rb');

	// send the right headers
	header("Content-Length: " . filesize($group));

	// dump the picture and stop the script
	fpassthru($fp);
	exit;

} else {

	//return default image
	$f = "/images/none.jpg";
	$fp = fopen($f, 'rb');

	// send the right headers
	header("Content-Length: " . filesize($f));

	// dump the picture and stop the script
	fpassthru($fp);
	exit;
}
