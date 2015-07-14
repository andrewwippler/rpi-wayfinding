<?php 

/**
 * This file is intended to remove duplicates from the database. A duplicate is the same event in the same room typically caused by all-day events.
 */


//SELECT DISTINCT *, COUNT(*) AS fieldCount FROM  rpiwayfinding GROUP BY EventName, Room, Bldg HAVING fieldCount > 1;

$query = "DELETE FROM rpiwayfinding USING rpiwayfinding, rpiwayfinding AS vtable 
		  WHERE (rpiwayfinding.PID > vtable.PID) 
			AND (rpiwayfinding.EventName=vtable.EventName) 
			AND (rpiwayfinding.Room=vtable.Room)
			AND (rpiwayfinding.Bldg=vtable.Bldg);";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_execute($stmt);

//SELECT * FROM events WHERE End <= '2015-07-14 10:45:33'

$query2 = "DELETED FROM events WHERE End <= '".date("Y-m-d H:i:s")."'";
$stmt2 = mysqli_prepare($con, $query2);
mysqli_stmt_execute($stmt2);



?>
