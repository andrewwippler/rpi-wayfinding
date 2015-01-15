<?php

/* 
 * Planning Center Online Resources retrieval
 * get yours at https://resources.planningcenteronline.com/widgets/(code).json

 */

include('ganon/ganon.php');

//Few needed strings
$today = date('Y-m-d');

$uri = urlencode($r['url']);

//this url defaults to today's date - perfect for what we need.
$url = "https://resources.planningcenteronline.com/widgets/{$uri}.json";

//JSON request
$json = file_get_contents($url);
$obj = json_decode($json);

//Parse JSON
//foreach ($obj->feed->entry as $o) {

 //  $endtime = $o->{'gd$when'}[0]->endTime;
 //   $starttime = $o->{'gd$when'}[0]->startTime;
//   $title = $o->title->{'$t'}; //produces "name: name" ... need to explode
//   $title = explode(":",$title);
//   $title = $title[0];
//   $title = trim('$title[0]');
//   $endtime = date("Y-m-d H:i:s", strtotime($endtime));
//   $starttime = date("Y-m-d H:i:s", strtotime($starttime));
    
 /*     //assuming still connected to database
    $query = "INSERT INTO events (EventName, Start, End, Room, Grp, Bldg) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $title, $starttime, $endtime, $r['name'], $r['group'], $r['bldg']);
    // Execute the statement 
    mysqli_stmt_execute($stmt);
  
*/
//}
