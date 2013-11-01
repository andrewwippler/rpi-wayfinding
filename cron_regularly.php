<?php
require('settings.php');
$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpi-wayfinding") or die("Connect failed: %s\n", mysqli_connect_error());

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

//check DB
$sql_check = "SELECT * FROM {$r['name']} LIMIT 3";

if ($result = mysqli_query($con, $sql_check)) {
    //todo: use default image if no results.

    while ($row = mysqli_fetch_row($result)) {
    
    //check for special words
    //capture events into string
    //    $row[0] 
    //    $row[1]
    //    $row[2]
    }
    
    //drop row if time has past
    
    
    //create image and upcoming event
    
    
    //create default image
    
    
    /* free result set */
    mysqli_free_result($result);
}




//make current event the room jpeg


}
}
mysqli_close($con);
