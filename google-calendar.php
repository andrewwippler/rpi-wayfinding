<?php

/* 
 * This file is intended to retrieve Calendar items from Google Calendar
 * Planning Center Online currently uses these.
 * 
 * Until PCO creates an API, the best way to grab these is by adding to a Google account and using JSON to grab them.
 *
 * Google has a limitation where the calendar feed updates once every 24 hours. :/
 */

//Few needed strings
$today = date('Y-m-d');
$uri = urlencode($r['url']);
$min = $today . urlencode('T00:00:01');
$max = $today . urlencode('T23:59:59');

$url = "http://www.google.com/calendar/feeds/{$uri}/public/full?alt=json&orderby=starttime&singleevents=true&sortorder=ascending&start-min={$min}&start-max={$max}";

//JSON request
$json = file_get_contents($url);
$obj = json_decode($json);

//Parse JSON
foreach ($obj->feed->entry as $o) {

   $endtime = $o->{'gd$when'}[0]->endTime;
   $starttime = $o->{'gd$when'}[0]->startTime;
   $endtime = date("Y-m-d H:i:s", strtotime($endtime));
   $starttime = date("Y-m-d H:i:s", strtotime($starttime));
    
      //assuming still connected to database
    $query = "INSERT INTO events (EventName, Start, End, Room, Group) VALUES (?,?,?,?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $title, $starttime, $endtime, $r['name'], $r['group']);
    /* Execute the statement */
    mysqli_stmt_execute($stmt);
  //  echo "Start: {$starttime}, End: {$endtime}, Title: {$title}";
  

