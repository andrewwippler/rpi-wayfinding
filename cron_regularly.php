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
					
				//drop appended theme
				$filtered = explode("|",$mainevent['name']);
				
					
				//check for special names
				include('special_names.php');
				$found = FALSE;
				foreach ($special as $s) {
				$s = strtolower($s);
				$checker = stristr(trim($filtered[0]),$s); // trimming to remove extra spaces at the end (if any)
				
						if (strtolower($checker) == $s) {
							
							$found = TRUE;
							break;
						}
				
					}
				}
			 
			if ($found == TRUE && !is_null($mainevent) && file_exists(__DIR__ . "/images/special-names/" . strtolower(trim($filtered[0])) . ".jpg")) {
			
			//create image
			$input = __DIR__ . "/images/special-names/" . strtolower(trim($filtered[0])) . ".jpg";
			$output = __DIR__ . "/images/" . strtolower($mainevent['room']) . ".jpg";
			file_put_contents($output, file_get_contents($input));
			
			} else if (!is_null($mainevent)) {
			
			$oldtheme = $theme;
			$filtered = explode("|",$mainevent['name']);
			$theme = $filtered[1];
			
			include(__DIR__ . "/theme/{$theme}/sign.php");
			
			//to prevent the new theme from propogating further
			$theme = $oldtheme;
			
			
			} else {
				
			//create default image
			$input = __DIR__ . "/theme/{$theme}/images/default-horizontal.jpg";
			$output = __DIR__ . "/images/" . strtolower($mainevent['room']) . ".jpg";
			file_put_contents($output, file_get_contents($input));
			

			}
		 
			/* free result set */
			mysqli_free_result($result);
		
	} else {
		
			//create default image
			$input = __DIR__ . "/theme/{$theme}/images/default-horizontal.jpg";
			$output = __DIR__ . "/images/" . strtolower($r['name']) . ".jpg";
			file_put_contents($output, file_get_contents($input));
			
		
	}
		
	}
		
		
	}
	$groups[] = $r['group'];
	$bldgs[] = $r['bldg'];
	
	
}

// special times
$special_times = FALSE;
$st = NULL;
$stb = NULL;
$stg = NULL;
include('special_times.php');

foreach ($specialt as $t) {

	
	if ($t['recurrence'] == '1') { //daily
		
		if ($t['start'] <= date('Gi') && date('Gi') <= $t['end']) {
			$special_times = TRUE;
			
		}
		
	} else if ($t['recurrence'] == '2') { //weekly
		
		if ($t['start'] <= date('DGi') && date('DGi') <= $t['end']) {
			$special_times = TRUE;
			
		}
		
	} else if ($t['recurrence'] == '3') { //monthly
		
		if ($t['start'] <= date('jMGi') && date('jMGi') <= $t['end']) {
			$special_times = TRUE;
			
		}
		
	} else if ($t['recurrence'] == '4') { //yearly
		
		if ($t['start'] <= date('jMYGi') && date('jMYGi') <= $t['end']) {
			$special_times = TRUE;
			
		}
		
	} else {
		// not supported
	}
	
	//FIX ME: currently the $stb and $stg get overwritten.
	if ($special_times == TRUE) { $st = strtolower($t['name']); $stb = strtolower($t['bldg']); $stg = strtolower($t['group']); break; }
	
}




$groups = array_unique($groups);

//check DB for groups
foreach($groups as $group) {
		$group = strtolower($group);
	if ($special_times == TRUE && file_exists(__DIR__ . "/images/special-times/" . $st . ".jpg") && $stg == $group) {
			
			$input = __DIR__ . "/images/special-times/". $st .".jpg";
			$output = __DIR__ . "/images/". $group .".jpg";
			file_put_contents($output, file_get_contents($input));
			
	} else {
		
	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

		// Create a blank image
		$im = imagecreatetruecolor($gix, $giy);
		$file = __DIR__ . "/images/" . $group . ".jpg";

		// Save the image 
		imagejpeg($im, $file);

		// Free up memory
		imagedestroy($im);

	} else {
		
	include($group_exec);	
					
		} else {
			//default
			$input = __DIR__ . "/theme/{$theme}/images/default-vertical.jpg";
			$output = __DIR__ . "/images/". strtolower($group) .".jpg";
			file_put_contents($output, file_get_contents($input));
			
		}
			
		}
	}
}

}

$bldgs = array_unique($bldgs);
//check DB for bldgs
foreach($bldgs as $b) {
	$b = strtolower($b);
	if ($special_times == TRUE && file_exists(__DIR__ . "/images/special-times/" . $st . ".jpg") && $stb == $b) {
			
			$input = __DIR__ . "/images/special-times/". $st .".jpg";
			$output = __DIR__ . "/images/".$b.".jpg";
			file_put_contents($output, file_get_contents($input));
			
	} else {
		
		
	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

		// Create a blank image
		$im = imagecreatetruecolor($bix, $biy);
		$file = __DIR__ . "/images/" . $b . ".jpg";

		// Save the image 
		imagejpeg($im, $file);

		// Free up memory
		imagedestroy($im);

	} else {
		
		include($bldg_exec);
		
		} else {
			//default
			$input = __DIR__ . "/theme/{$theme}/images/default-vertical.jpg";
			$output = __DIR__ . "/images/".$b.".jpg";
			file_put_contents($output, file_get_contents($input));
			
		}
			
		}
	}
 }

}

mysqli_close($con);
