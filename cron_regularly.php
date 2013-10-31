<?php
require('settings.php');
$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpi-wayfinding") or die("Connect failed: %s\n", mysqli_connect_error());

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


//check for special words in subject line. Special words have special images and do not 


//make current event the room jpeg



}
mysqli_close($con);
