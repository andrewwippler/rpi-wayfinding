<?php
/*
 * This file is intended to serve the right image.
 *
 *
 */
// Set the content type header - in this case image/jpeg
header('Content-Type: image/jpeg');
require('rooms.php');

if (isset($_GET["g"])) { 
	$image = __DIR__ . "/images/" . strtolower($_GET["g"]) . ".jpg"; 
} else if (isset($_GET["b"])) { 
	$image = __DIR__ . "/images/" . strtolower($_GET["b"]) . ".jpg"; 
} else {
	$i = NULL;
	//grab url information
	//should be hostname of RPi via puppet or any other URI
	foreach ($rooms as $r) {
		foreach ($r['rpi'] as $h) {

			if (strtolower($_GET["i"]) == strtolower($h)) {
				$i = TRUE;
				break;
			}
		}
		//end the foreach when hostname/rpi is found
		if (!is_null($i)) { $image = __DIR__ . "/images/" . strtolower($r['name']) . ".jpg"; break; }
	}

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

} else {

	//return default image
	$f = __DIR__ . "/images/none.jpg";
	$fp = fopen($f, 'rb');

	// send the right headers
	header("Content-Length: " . filesize($f));

	// dump the picture and stop the script
	fpassthru($fp);
	exit;
}
