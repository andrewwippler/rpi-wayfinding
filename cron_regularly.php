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
$sql_check = "SELECT * FROM {$r['name']} LIMIT 3"; // limiting to 3 requests because we do not need any more.

if ($result = mysqli_query($con, $sql_check)) {
    //todo: use default image if no results.

    $result_set = new array();
    $i = 0;
    $one_event = FALSE;
    $two_events = FALSE;
    $three_events = FALSE;
    $mainevent = NULL;

    while ($row = mysqli_fetch_row($result)) {
    //capture events into string
    $result_set[$i] = array('name' => $row[0], 'start' => $row[1], 'end' => $row[2]);
    $i++;
    }
    
    if (is_array($result_set[0])) { 
    $one_event = TRUE;
    }
    
    if (is_array($result_set[1])) { 
    $two_events = TRUE;
    }
    
    if (is_array($result_set[2])) { 
    $three_events = TRUE;
    }    
    
    //drop row if time has past
    if ($one_event == TRUE && strtotime($result_set[0]['end']) <= time()) {
    
    //todo create mysql drop
    
    
    if ($two_events == TRUE) {
        $mainevent = $result_set[1];
    }
    
    }
    
    
    //check for special names
    include('special_names.php');
    $checker = stripos($mainevent['name'],$special); //case-insensitive
    if ($checker !== false && !is_null($mainevent)) {
    
    //todo: what to do when found special name
    
    } else if (!is_null($mainevent)) {
    
    //create image and upcoming event
    
    } else {
    
    //create default image
    
    }
    
    
    
    
    /* free result set */
    mysqli_free_result($result);
}
}
}
mysqli_close($con);
