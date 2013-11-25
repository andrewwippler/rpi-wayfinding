<?php
require('settings.php');
$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s\n". mysqli_connect_error());


foreach($rooms as $r) {

	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

	// Create a blank image
	$im = imagecreatetruecolor($ix, $iy);
	$file = __DIR__ . "/images/" . strtolower($r['name']) . ".jpg";

	// Save the image 
	imagejpeg($im, $file);

	// Free up memory
	imagedestroy($im);

	} else {

		//check DB for rooms
		$sql_check = "SELECT * FROM events WHERE Room='". $r["name"] . "' LIMIT 3"; // limiting to 3 requests because we do not need any more.

		if ($result = mysqli_query($con, $sql_check)) {
			
			$result_set = array();
			$one_event = FALSE;
			$two_events = FALSE;
			$three_events = FALSE;
			$mainevent = NULL;
			$secevent = NULL;

			while ($row = mysqli_fetch_row($result)) {
			//capture events into string
			$result_set[] = array('id' => $row[0], 'name' => $row[1], 'start' => $row[2], 'end' => $row[3], 'room' => $row[4]);
			
			}
		if (isset($result_set[0])){
			
			$one_event = TRUE;
			$mainevent = $result_set[0];
			
			
			if (is_array($result_set[1])) { 
			$two_events = TRUE;
			$secevent = $result_set[1];
			}
			
			if (is_array($result_set[2])) { 
			$three_events = TRUE;
			}    
			
			//drop row if time has past
			if ($one_event == TRUE && strtotime($result_set[0]['end']) <= time()) {
			
			//mysql drop
			$stmt = mysqli_prepare($con, "DELETE FROM events WHERE PID=?");
			mysqli_stmt_bind_param($stmt, "i", $result_set[0]['id']);
			mysqli_stmt_execute($stmt);
			
			//move main event to second if applicable
			if ($two_events == TRUE) {
				$mainevent = $result_set[1];
				
				//cleanup for up next item
					if ($three_events == TRUE) {
						$secevent = $result_set[2]; 
					} else {
						$secevent = NULL;
						$two_events = FALSE; //Clearing this for image creation issues.
					}
				} else {
					//kill main event
					$mainevent = NULL;	
				}
			
			}
			
				if (!is_null($mainevent)) {
				//check for special names
				include('special_names.php');
				$found = FALSE;
				echo $mainevent['name'] ."<br />";
				foreach ($special as $s) {
				$checker = stristr(trim($mainevent['name']),$s); // trimming to remove extra spaces at the end (if any)
				
						if ($checker == $s) {
							$found = TRUE;
							break;
						}
				
					}
				}
			 
			if ($found == TRUE && !is_null($mainevent)) {
			
			//create image
			$input = __DIR__ . "/images/special-names/" . strtolower($mainevent['name']) . ".jpg";
			$output = __DIR__ . "/images/" . strtolower($mainevent['room']) . ".jpg";
			file_put_contents($output, file_get_contents($input));
			
			} else if (!is_null($mainevent)) {
			
			include('image_create.php');
			
			} else {
				
			//create default image
			$input = __DIR__ . "/images/default-horizontal.jpg";
			$output = __DIR__ . "/images/" . strtolower($mainevent['room']) . ".jpg";
			file_put_contents($output, file_get_contents($input));
			

			}
		 
			/* free result set */
			mysqli_free_result($result);
		
	} else {
		
			//create default image
			$input = __DIR__ . "/images/default-horizontal.jpg";
			$output = __DIR__ . "/images/" . strtolower($r['name']) . ".jpg";
			file_put_contents($output, file_get_contents($input));
			
		
	}
		
	}
		
		
	}
	$groups[] = $r['group'];
	$bldgs[] = $r['bldg'];
	
	
}

$groups = array_unique($groups);

//check DB for groups
foreach($groups as $group) {
		
	//todo: special events for group signs
		
		
	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

		// Create a blank image
		$im = imagecreatetruecolor($gix, $giy);
		$file = __DIR__ . "/images/" . strtolower($group) . ".jpg";

		// Save the image 
		imagejpeg($im, $file);

		// Free up memory
		imagedestroy($im);

	} else {
		
		
		$sql_check = "SELECT E.*, COUNT(*) AS ct
						   FROM events E
						   JOIN (SELECT *
									  FROM events
									  WHERE Grp='". $group ."' 
									  GROUP by Room) E2 ON E2.PID = E.PID
						   GROUP BY E.Room
						   ORDER BY E.Room ASC "; 
						 

		if ($result = mysqli_query($con, $sql_check)) {
			
			$result_set = array();
		
		while ($row = mysqli_fetch_row($result)) {
		//capture events into string
		$result_set[] = array('id' => $row[0], 'name' => $row[1], 'start' => $row[2], 'end' => $row[3], 'room' => $row[4]);

		}
		
		$y = 220;
		if (isset($result_set[0])) {
		$im = @imagecreatefromjpeg($vertimg);
	
	$black = imagecolorallocate($im, 0, 0, 0);
	$white = imagecolorallocate($im, 255, 255, 255);
	/* See if it failed */
	if($im) {
		
		
			foreach($result_set as $gi) {

		$group_time = date("g:i a",strtotime($gi["start"])) . " - " . date("g:i a",strtotime($gi["end"]));
		$event_sub = substr($gi['name'], 0, 84);
	
					//room first
					$x = 20;
					$y = $y + 60; // from above. Marker is at bottom mof text.

					// Write it
					imagettftext($im, 20, 0, $x, $y, $black, $groupfont, preg_replace('/-/', ' ',$gi['room']));

					//Event subject
					$x = $x + 140;				
					imagettftext($im, 20, 0, $x, $y, $black, $groupfont, $event_sub);		
					
					//time
					$x = $x + 650;
					imagettftext($im, 20, 0, $x, $y, $black, $groupfont, $group_time);
				}
					$file = __DIR__ . "/images/" . strtolower($group). ".jpg";

				// Save the image 
				imagejpeg($im, $file);
		
// Free up memory
			imagedestroy($im);
}

/* free result set */
			mysqli_free_result($result);
			
		} else {
			//default
			$input = __DIR__ . "/images/default-vertical.jpg";
			$output = __DIR__ . "/images/". strtolower($group) .".jpg";
			file_put_contents($output, file_get_contents($input));
			
		}
			
		}
	}


}

$bldgs = array_unique($bldgs);
//check DB for bldgs
foreach($bldgs as $b) {
		
	//todo: special events for group signs
		
		
	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

		// Create a blank image
		$im = imagecreatetruecolor($bix, $biy);
		$file = __DIR__ . "/images/" . strtolower($b) . ".jpg";

		// Save the image 
		imagejpeg($im, $file);

		// Free up memory
		imagedestroy($im);

	} else {
		
		
		$sql_check = "SELECT E.*, COUNT(*) AS ct
						   FROM events E
						   JOIN (SELECT *
									  FROM events 
									  GROUP by Room) E2 ON E2.PID = E.PID
						   GROUP BY E.Room
						   ORDER BY E.Room ASC "; //needs limit clause
						 

		if ($result = mysqli_query($con, $sql_check)) {
			
			$result_set = array();
		
		while ($row = mysqli_fetch_row($result)) {
		//capture events into string
		$result_set[] = array('id' => $row[0], 'name' => $row[1], 'start' => $row[2], 'end' => $row[3], 'room' => $row[4]);

		}
		
		$y = 220;
		if (isset($result_set[0])) {
		$im = @imagecreatefromjpeg($vertimg);
	
	$black = imagecolorallocate($im, 0, 0, 0);
	$white = imagecolorallocate($im, 255, 255, 255);
	/* See if it failed */
	if($im) {
		
		
			foreach($result_set as $bi) {

		$bldg_time = date("g:i a",strtotime($bi["start"])) . " - " . date("g:i a",strtotime($bi["end"]));
		$event_sub = substr($bi['name'], 0, 84);
	
					//room first
					$x = 20;
					$y = $y + 60; // from above. Marker is at bottom mof text.

					// Write it
					imagettftext($im, 20, 0, $x, $y, $black, $bldgfont, preg_replace('/-/', ' ',$bi['room']));

					//Event subject
					$x = $x + 140;				
					imagettftext($im, 20, 0, $x, $y, $black, $bldgfont, $event_sub);		
					
					//time
					$x = $x + 650;
					imagettftext($im, 20, 0, $x, $y, $black, $bldgfont, $bldg_time);
				}
					$file = __DIR__ . "/images/".strtolower($b).".jpg";

				// Save the image 
				imagejpeg($im, $file);
		
// Free up memory
			imagedestroy($im);
}

/* free result set */
			mysqli_free_result($result);
			
		} else {
			//default
			$input = __DIR__ . "/images/default-vertical.jpg";
			$output = __DIR__ . "/images/".strtolower($b).".jpg";
			file_put_contents($output, file_get_contents($input));
			
		}
			
		}
	}


}

mysqli_close($con);
