<?php

/* 
 * This file is intended to pull every room resource and place them in jpg files.
 * The end result is /images/<room_name_location>.jpg
 */

require("settings.php");

foreach($rooms as $r) {

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

//create image by connecting to respective item


}

}
