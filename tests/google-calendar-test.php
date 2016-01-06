<?php

/*
 * This file is intended to retrieve Calendar items from Google Calendar.
 */

//Few needed strings
$today = date('Y-m-d');

$time = urlencode('T'.date('H:i:s'));

$uri = urlencode($r['url']);
$min = $today . $time;
$max = $today . urlencode('T23:59:59');

$url = "http://www.google.com/calendar/feeds/{$uri}/public/full?alt=json&orderby=starttime&singleevents=true&sortorder=ascending&start-min={$min}&start-max={$max}";

//JSON request
if ($json = file_get_contents($url)) {
	echo "Able to connect to a Google Calendar.<br />";
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
			echo "This event was found: {$title}, start: {$starttime}, end: {$endtime}.<br />";

}

} else {
  echo "Unable to get a Google calendar.<br />";
}
