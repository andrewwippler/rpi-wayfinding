<?php

/* 
 * This file is intended to pull every room resource and place them in jpg files.
 * The end result is /images/<room_name_location>.jpg
 */

require("settings.php");
if ($_GET["p"] == $passcode) {
	
	$force = TRUE;

	$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s\n". mysqli_connect_error());

	//empty the table - empties everything and restarts PID to 0
	$stmt = mysqli_prepare($con, "TRUNCATE TABLE events");
	mysqli_stmt_execute($stmt);

	foreach($rooms as $r) {

		//create daily events
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
	
	mysqli_close($con);

	//todo: add optional mail to recipient when completed.

} else {
	echo "Invalid passcode. Quitting...";
	
}
