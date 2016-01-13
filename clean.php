<?php

/**
 * This file is intended to remove duplicates from the database. A duplicate is the same event in the same room typically caused by all-day events.
 */


//SELECT DISTINCT *, COUNT(*) AS fieldCount FROM  rpiwayfinding GROUP BY EventName, Room, Bldg HAVING fieldCount > 1;

$query = "DELETE FROM events USING events, events AS vtable
		  WHERE (events.PID > vtable.PID)
			AND (events.EventName=vtable.EventName)
			AND (events.Room=vtable.Room)
			AND (events.Bldg=vtable.Bldg);";
$stmt = mysqli_prepare($con, $query) or die(mysqli_error($con));
mysqli_stmt_execute($stmt);

//SELECT * FROM events WHERE End <= NOW()

$query2 = "DELETE FROM events WHERE End <= '".date("Y-m-d H:i:s")."'";
$stmt2 = mysqli_prepare($con, $query2) or die(mysqli_error($con));
mysqli_stmt_execute($stmt2);



?>
