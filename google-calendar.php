<?php

/* 
 * This file is intended to retrieve Calendar items from Google Calendar.
 */

//Few needed strings
$today = date('Y-m-d');

if ($force == TRUE) {
	$time = urlencode('T'.date('H:i:s'));

} else {
	$time = urlencode('T00:00:01');
}

$uri = urlencode($r['url']);
$min = $today . $time;
$max = $today . urlencode('T23:59:59');

$url = "http://www.google.com/calendar/feeds/{$uri}/public/full?alt=json&orderby=starttime&singleevents=true&sortorder=ascending&start-min={$min}&start-max={$max}";

//JSON request
$json = file_get_contents($url);
$obj = json_decode($json);

//Parse JSON
foreach ($obj->feed->entry as $o) {

   $endtime = $o->{'gd$when'}[0]->endTime;
   $starttime = $o->{'gd$when'}[0]->startTime;
   $title = $o->title->{'$t'}; 
   $title = trim('$title');
 
   $endtime = date("Y-m-d H:i:s", strtotime($endtime));
   $starttime = date("Y-m-d H:i:s", strtotime($starttime));
    
      //assuming still connected to database
    $query = "INSERT INTO events (EventName, Start, End, Room, Grp, Bldg) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $title, $starttime, $endtime, $r['name'], $r['group'], $r['bldg']);
    /* Execute the statement */
    mysqli_stmt_execute($stmt);

}
