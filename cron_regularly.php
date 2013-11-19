<?php
require('settings.php');
$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s\n". mysqli_connect_error());

foreach($rooms as $r) {

	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

	// Create a blank image
	$im = imagecreatetruecolor($ix, $iy);
	$file = __DIR__ . "/images/" . $r['name'] . ".jpg";

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
			
			if (is_array($result_set[0])) { 
			$one_event = TRUE;
			$mainevent = $result_set[0];
			}
			
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
				foreach ($special as $s) {
				$checker = stripos(trim($mainevent['name']),$s); // trimming to remove extra spaces at the end (if any)
				
						if ($checker !== false) {
							$found = TRUE;
							break;
						}
				
					}
				}
			 
			if ($found == TRUE && !is_null($mainevent)) {
			
			//create image
			$input = __DIR__ . "/images/special-names/" . $mainevent['name'] . ".jpg";
			$output = __DIR__ . "/images/" . $mainevent['room'] . ".jpg";
			file_put_contents($output, file_get_contents($input));
			
			} else if (!is_null($mainevent)) {
			
			include('image_create.php');
			
			} else {
			
			//create default image
			$input = __DIR__ . "/images/blanks/default.jpg";
			$output = __DIR__ . "/images/" . $mainevent['room'] . ".jpg";
			file_put_contents($output, file_get_contents($input));
			
			}
		 
			/* free result set */
			mysqli_free_result($result);
		}
		
		//check DB for rooms
		foreach($r['group'] as $group) {
		
			$sql_check = "SELECT * FROM events WHERE Grp='". $group . "'"; 

			if ($result = mysqli_query($con, $sql_check)) {
				$result_set = array();
				
				while ($row = mysqli_fetch_row($result)) {
				//capture events into string
				$result_set[] = array('id' => $row[0], 'name' => $row[1], 'start' => $row[2], 'end' => $row[3], 'room' => $row[4]);
				
				}
				
				
				//todo: special events for group signs
				
				
				//items should be already dropped from above code
				
				//append items to list form
				foreach($result_set as $gi) {
					
					$im = imagecreatetruecolor($gix, $giy);
					$black = imagecolorallocate($im, 0, 0, 0);
					$white = imagecolorallocate($im, 255, 255, 255);

					 /* Attempt to open */
						$im = @imagecreatefromjpeg($vertimg);

						/* See if it failed */
						if(!$im)
						{
							/* Create a black image */
							$im  = imagecreatetruecolor($gix, $giy);
							$bgc = imagecolorallocate($im, 255, 255, 255);
							$tc  = imagecolorallocate($im, 0, 0, 0);

							imagefilledrectangle($im, 0, 0, $gix, $giy, $bgc);

							/* Output an error message */
							imagestring($im, 1, 5, 5, 'Error loading ' . $horizim, $tc);
						} else {

						$eventtext = wordwrap($gi['name'], 45, "\n");


						if (strlen($eventtext) > 45) {

							$newtext = explode("\n", $eventtext);
							
							// First we create our bounding box for the first text
							$bbox = imagettfbbox(72, 0, $font, $eventtext[0]);

							// This is our cordinates for X and Y
							$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
							$y = 514 - 14; // middle of screen, bump up  14px

							// Write it
							imagettftext($im, 72, 0, $x, $y, $black, $font, $eventtext[0]);
							
							// First we create our bounding box for the second text
							$bbox = imagettfbbox(72, 0, $font, $eventtext[1]);

							// This is our cordinates for X and Y
							$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
							$y = $y + 96; // add font size + 24px

							// Write it
							imagettftext($im, 72, 0, $x, $y, $black, $font, $eventtext[1]);
							
							// Create the next bounding box for the second text
							$bbox = imagettfbbox(48, 0, $font, $group_time);

							// Set the cordinates so its next to the first text
							$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
							$y = $y + 82; //add font size + 10px for spacing

							// Write it
							imagettftext($im, 48, 0, $x, $y, $black, $font, $group_time);

						} else {
							
							// First we create our bounding box for the first text
							$bbox = imagettfbbox(72, 0, $font, $eventtext);

							// This is our cordinates for X and Y
							$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
							$y = 550 - 10; // middle of screen, bump up  10px

							// Write it
							imagettftext($im, 72, 0, $x, $y, $black, $font, $eventtext);

							// Create the next bounding box for the second text
							$bbox = imagettfbbox(48, 0, $font, $group_time);

							// Set the cordinates so its next to the first text
							$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
							$y = 550 + 82; //middle of screen + above text size + 10px for spacing

							// Write it
							imagettftext($im, 48, 0, $x, $y, $black, $font, $group_time);
							
						}

						$file = __DIR__ . "/images/{$group}.jpg";

						// Save the image 
						imagejpeg($im, $file);

					}

					// Free up memory
					imagedestroy($im);
					
					
				}
				
			
				/* free result set */
				mysqli_free_result($result);
				
			}
		}
		
		
	}
}
mysqli_close($con);
