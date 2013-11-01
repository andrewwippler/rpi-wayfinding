<?php

/* 
 * This file is intended to pull every room resource and place them in jpg files.
 * The end result is /images/<room_name_location>.jpg
 */

require("settings.php");

$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpi-wayfinding") or die("Connect failed: %s\n", mysqli_connect_error());

foreach($rooms as $r) {

//create tables for the rooms
$sql = "CREATE TABLE IF NOT EXISTS " . $r['name'];
$sql .= " (
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
EventName TEXT,
Start DATETIME,
End DATETIME
)";

// Execute query
mysqli_query($con,$sql) or die("Error creating table: " . mysqli_error($con);


//create daily events
if ($r['type'] == 1) {

include('exchange.php');

} else if ($r['type'] == 2) {

include('planning-center.php');

} else {

//you need to make your own code.

}

}
mysqli_close($con);

//todo: add optional mail to recipient when completed.

