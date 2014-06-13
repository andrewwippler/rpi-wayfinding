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

?>