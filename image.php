<?php
/*
 * This file is intended to serve the right image.
 *
 *
 */

// Set the content type header - in this case image/jpeg
header('Content-Type: image/jpeg');

//grab url information
//should be hostname of RPi
$image = $_GET["i"] . ".jpg";

//find right image in directory
if (file_exists($image)) {

// open the file in a binary mode
$f = "/images/" . $image;
$fp = fopen($f, 'rb');

// send the right headers
header("Content-Length: " . filesize($f));

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
