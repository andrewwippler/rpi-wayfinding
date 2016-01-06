<?php

require('settings.php');
$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s\n". mysqli_connect_error());

echo "Checking for rooms...\n\n";
if (is_array($rooms[0]['name'])) { echo "Found first room: {$rooms[0]['name']}"; } else { echo "ERROR: No rooms found"; }

echo "\n\n";

echo "Checking events table...\n\n";

$sql_check = "SELECT * FROM events";
if ($result = mysqli_query($con, $sql_check)) {
echo "Found these results: \n";

  while ($row = mysqli_fetch_row($result)) {
    echo "id: {$row[0]}, name: {$row[1]}, start: {$row[2]}, end: {$row[3]}, room: {$row[4]}\n";
  }


} else {
echo "No results found in database.\n\n";
echo "Attempting to gather information from the first room listed...\n";

$r = $rooms[0];

if ($r['type'] == 1) {

include('exchange.php');

} else if ($r['type'] == 2) {

include('planning-center.php');

} else if ($r['type'] == 3) {

include('google-calendar.php');

} else {

//you need to make your own code.

}

}
