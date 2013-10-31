<?php
require('settings.php');

//blank between hours - adjust in settings.php
if (date("G:i") <= $end_time && date("G:i") <= $start_time) {

// Create a blank image
$im = imagecreatetruecolor(1920, 1080);

$file = "/images/" . $r['name'] . ".jpg";
// Save the image 
imagejpeg($im, $file);

// Free up memory
imagedestroy($im);

} else {

//check DB and drop row if time has past.


//make current event the room jpeg



}
