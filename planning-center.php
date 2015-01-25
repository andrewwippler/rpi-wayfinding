<?php

/* 
 * Planning Center Online Resources retrieval
 * get yours at https://resources.planningcenteronline.com/widgets/(code).json

 */



$uri = urlencode($r['url']);

//this url defaults to today's date - perfect for what we need.
$url = "https://resources.planningcenteronline.com/widgets/".$uri.".json";

//JSON request
$json = file_get_contents($url);
$obj = json_decode($json);
// a new dom object
$dom = new domDocument;
 
// load the html into the object
$dom->loadHTML($obj->html);
 
// discard white space
$dom->preserveWhiteSpace = false;

foreach ($dom->getElementsByTagName('tr') as $e) {
	$ex = explode("     ",$e->nodeValue);
	
	$array[] = array("time" => preg_replace('!\s+!', ' ', $ex[0]), "subj" => preg_replace('!\s+!', ' ', $ex[2]));
}

//remove the first 2 values (we don't need them)
$array = array_slice($array, 2); 


//Parse array
foreach ($array as $o) {
    if (strlen($o['time']) > 5) { //time comes back as " 8:00a" from planning center
	$time = explode(" - ", $o['time']);
    $endtime = $time[1]."m"; //adding a final M to the string. Otherwise returns invalid date/time.
    $starttime = $time[0]."m";
    $title = $o['subj'];
    $endtime = date("Y-m-d H:i:s", strtotime($endtime));
    $starttime = date("Y-m-d H:i:s", strtotime($starttime));
 
      //assuming still connected to database
    $query = "INSERT INTO events (EventName, Start, End, Room, Grp, Bldg) VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $title, $starttime, $endtime, $r['name'], $r['group'], $r['bldg']);
    // Execute the statement 
    mysqli_stmt_execute($stmt);
    unset($array);
    }
}
