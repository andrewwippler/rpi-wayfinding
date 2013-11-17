<?php
require('settings.php');
$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s\n". mysqli_connect_error());

foreach($rooms as $r) {

//blank between hours - adjust in settings.php
if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

// Create a blank image
$im = imagecreatetruecolor(1920, 1080);
$file = "/images/" . $r['name'] . ".jpg";

// Save the image 
imagejpeg($im, $file);

// Free up memory
imagedestroy($im);

} else {

//check DB
$sql_check = "SELECT * FROM events WHERE Room='". $r["name"] . "' LIMIT 3"; // limiting to 3 requests because we do not need any more.

if ($result = mysqli_query($con, $sql_check)) {
    
    $result_set = array();
    $one_event = FALSE;
    $two_events = FALSE;
    $three_events = FALSE;
    $mainevent = NULL;
    $secevent = NULL;

    while ($row = mysqli_fetch_row($result)) {
    //capture events into string
    $result_set[] = array('id' => $row[0], 'name' => $row[1], 'start' => $row[2], 'end' => $row[3], 'room' => $row[4]);
    
    }
    
    if (is_array($result_set[0])) { 
    $one_event = TRUE;
    $mainevent = $result_set[0];
    }
    
    if (is_array($result_set[1])) { 
    $two_events = TRUE;
    $secevent = $result_set[1];
    }
    
    if (is_array($result_set[2])) { 
    $three_events = TRUE;
    }    
    
    //drop row if time has past
    if ($one_event == TRUE && strtotime($result_set[0]['end']) <= time()) {
    
    //mysql drop
    $stmt = mysqli_prepare($con, "DELETE FROM events WHERE PID=?");
    mysqli_stmt_bind_param($stmt, "i", $result_set[0]['id']);
    mysqli_stmt_execute($stmt);
    
    //move main event to second if applicable
    if ($two_events == TRUE) {
        $mainevent = $result_set[1];
        
        //cleanup for up next item
        if ($three_events == TRUE) {
			$secevent = $result_set[2]; 
		} else {
			$secevent = NULL;
		}
    } 
    
    }
    
    
    //check for special names
    include('special_names.php');
    $found = FALSE;
    foreach ($special as $s) {
    $checker = stripos(trim($mainevent['name']),$s); // trimming to remove extra spaces at the end (if any)
    
		if ($checker !== false) {
			$found = TRUE;
			break;
		}
    
    }
     
    if ($found == TRUE && !is_null($mainevent)) {
    
    //create image
    $input = "/images/special-names/" . $mainevent['name'] . ".jpg";
	$output = "/images/" . $mainevent['room'] . ".jpg";
	file_put_contents($output, file_get_contents($input));
    
    } else if (!is_null($mainevent)) {
    
    //create image and upcoming event
    //$im = imagecreatetruecolor(1920, 1080);
	//$file = "/images/" . $mainevent['name'] . ".jpg";
	// Save the image 
	//imagejpeg($im, $file);

	// Free up memory
	//imagedestroy($im);
    
    } else {
    
    //create default image
    $input = "/images/blanks/default.jpg";
	$output = "/images/" . $mainevent['room'] . ".jpg";
	file_put_contents($output, file_get_contents($input));
    
    }
    
    
    
    
    /* free result set */
    mysqli_free_result($result);
}
}
}
mysqli_close($con);
