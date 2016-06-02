<?php
require('settings.php');
$con = mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s\n". mysqli_connect_error());

//solid colors for backgrounds during off hours.
switch (date("w")) {
    case "0":
        $color1 = "255";
        $color2 = "0";
        $color3 = "0";
        break;
    case "1":
        $color1 = "0";
        $color2 = "255";
        $color3 = "0";
        break;
    case "2":
        $color1 = "0";
        $color2 = "0";
        $color3 = "255";
        break;
    case "3":
        $color1 = "255";
        $color2 = "255";
        $color3 = "0";
        break;
    case "4":
        $color1 = "255";
        $color2 = "0";
        $color3 = "255";
        break;
    case "5":
        $color1 = "0";
        $color2 = "255";
        $color3 = "255";
        break;
    case "6":
        $color1 = "0";
        $color2 = "0";
        $color3 = "0";
        break;
}

// Loop through rooms

foreach($rooms as $r) {

	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

	// Create a blank image
	$im = imagecreatetruecolor($ix, $iy);
	$color = imagecolorallocate($im, $color1, $color2, $color3);
	imagefilledrectangle($im, 0, 0, $ix, $iy, $color);
	$file = __DIR__ . "/images/" . strtolower($r['name']) . ".png";

	// Save the image
	imagepng($im, $file);

	// Free up memory
	imagedestroy($im);

	} else {

		//check DB for rooms
		$sql_check = "SELECT * FROM events WHERE Room='". $r["name"] . "' ORDER BY Start LIMIT 3"; // limiting to 3 requests because we do not need any more.

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


			if (isset($result_set[1]) && is_array($result_set[1])) {
			$two_events = TRUE;
			$secevent = $result_set[1];
			}

			if (isset($result_set[2]) && is_array($result_set[2])) {
			$three_events = TRUE;
			}

			//drop row if time has past
			if ($one_event == TRUE && strtotime($result_set[0]['end']) <= time()) {
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

			if ($found == TRUE && !is_null($mainevent) && file_exists(__DIR__ . "/images/special-names/" . strtolower(trim($filtered[0])) . ".png")) {

			//create image
			$input = __DIR__ . "/images/special-names/" . strtolower(trim($filtered[0])) . ".png";
			$output = __DIR__ . "/images/" . strtolower($mainevent['room']) . ".png";
			file_put_contents($output, file_get_contents($input));

			} else if (!is_null($mainevent)) {

			$oldtheme = $theme;
			$filtered = explode("|",$mainevent['name']);

			if(isset($filtered[1])) {
				$theme = $filtered[1];
			} else {
				$theme = $oldtheme;
			}

			include(__DIR__ . "/theme/{$theme}/sign.php");

			//to prevent the new theme from propogating further
			$theme = $oldtheme;

			} else {

			//create default image
			$input = __DIR__ . "/theme/{$theme}/images/default-horizontal.png";
			$output = __DIR__ . "/images/" . strtolower($mainevent['room']) . ".png";
			file_put_contents($output, file_get_contents($input));

			}

			/* free result set */
			mysqli_free_result($result);

	} else {

			//create default image
			$input = __DIR__ . "/theme/{$theme}/images/default-horizontal.png";
			$output = __DIR__ . "/images/" . strtolower($r['name']) . ".png";
			file_put_contents($output, file_get_contents($input));

	}
}

	}
	$groups[] = $r['group'];
	$bldgs[] = $r['bldg'];

}

// special times
$special_times = FALSE;
$sta = array(); //array to keep all information

include('special_times.php');

foreach ($specialt as $t) {

	if ($t['recurrence'] == '1') { //daily

		if ($t['start'] <= date('Gi') && date('Gi') <= $t['end']) {
			$special_times = TRUE;
			$sta[] = strtolower($t['name']) . "|" . strtolower($t['bldg']) . "|" . strtolower($t['group']);
		}

	} else if ($t['recurrence'] == '2') { //weekly

		if ($t['start'] <= date('DGi') && date('DGi') <= $t['end']) {
			$special_times = TRUE;
			$sta[] = strtolower($t['name']) . "|" . strtolower($t['bldg']) . "|" . strtolower($t['group']);
		}

	} else if ($t['recurrence'] == '3') { //monthly

		if ($t['start'] <= date('jMGi') && date('jMGi') <= $t['end']) {
			$special_times = TRUE;
			$sta[] = strtolower($t['name']) . "|" . strtolower($t['bldg']) . "|" . strtolower($t['group']);
		}

	} else if ($t['recurrence'] == '4') { //yearly

		if ($t['start'] <= date('jMYGi') && date('jMYGi') <= $t['end']) {
			$special_times = TRUE;
			$sta[] = strtolower($t['name']) . "|" . strtolower($t['bldg']) . "|" . strtolower($t['group']);
		}

	} else {
		// not supported
	}
		$sta[] = "bogus|for|error-sake";
		$st = array_unique($sta);
}

// Loop through groups/floors

$groups = array_unique($groups);

//check DB for groups
foreach($groups as $group) {
		$group = strtolower($group);
	if ($special_times == TRUE) {

		foreach ($st as $t) {

			$special_time = explode("|", $t);

			if (file_exists(__DIR__ . "/images/special-times/" . $special_time[0] . " " . $special_time[2] . ".png") && $special_time[2] == $group) {

				$input = __DIR__ . "/images/special-times/" . $special_time[0] . " " . $special_time[2] . ".png";
				$output = __DIR__ . "/images/". $group .".png";
				file_put_contents($output, file_get_contents($input));
			}
		}
	} else {

	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

		// Create a blank image
		$im = imagecreatetruecolor($gix, $giy);
		$color = imagecolorallocate($im, $color1, $color2, $color3);
		imagefilledrectangle($im, 0, 0, $gix, $giy, $color);
		$file = __DIR__ . "/images/" . $group . ".png";

		// Save the image
		imagepng($im, $file);

		// Free up memory
		imagedestroy($im);

	} else {
		$sql_check = "SELECT E.*, COUNT(*) AS ct
						   FROM events E
						   JOIN (SELECT *
									  FROM events
									  WHERE Grp='". $group ."'
									  GROUP BY Room
									  ORDER BY Start) E2 ON E2.PID = E.PID
						   GROUP BY E.Room
						   ORDER BY E.Room, E.Start ";

		if ($result = mysqli_query($con, $sql_check)) {

			$result_set = array();

            if (mysqli_num_rows($result) >= 1) {
                while ($row = mysqli_fetch_row($result)) {
                //capture events into string
                $result_set[] = array('id' => $row[0], 'name' => $row[1], 'start' => $row[2], 'end' => $row[3], 'room' => $row[4]);

                }

                include($group_exec);

                /* free result set */
                mysqli_free_result($result);

                } else {
                    //default
                    $input = __DIR__ . "/theme/{$theme}/images/default-vertical.png";
                    $output = __DIR__ . "/images/". strtolower($group) .".png";
                    file_put_contents($output, file_get_contents($input));
                }
			}
		}
	}
}

// Loop through buildings

$bldgs = array_unique($bldgs);
//check DB for bldgs
foreach($bldgs as $b) {
	$b = strtolower($b);
	if ($special_times == TRUE) {

		foreach ($st as $t) {

			$special_time = explode("|", $t);

			if (file_exists(__DIR__ . "/images/special-times/" . $special_time[0] . " " . $special_time[1] . ".png") && $special_time[1] == $b) {

				$input = __DIR__ . "/images/special-times/" . $special_time[0] . " " . $special_time[1] . ".png";
				$output = __DIR__ . "/images/". $b .".png";
				file_put_contents($output, file_get_contents($input));
			}
		}
	} else {

	//blank between hours - adjust in settings.php
	if (date("G:i") <= $end_time && date("G:i") >= $start_time) {

		// Create a blank image
		$im = imagecreatetruecolor($bix, $biy);
		$color = imagecolorallocate($im, $color1, $color2, $color3);
		imagefilledrectangle($im, 0, 0, $bix, $biy, $color);
		$file = __DIR__ . "/images/" . $b . ".png";

		// Save the image
		imagepng($im, $file);

		// Free up memory
		imagedestroy($im);

	} else {

		$sql_check = "SELECT E.*, COUNT(*) AS ct
						   FROM events E
						WHERE Bldg='" . $b . "'
						   JOIN (SELECT *
									  FROM events
									  GROUP BY Room
									  ORDER BY Start) E2 ON E2.PID = E.PID
						   GROUP BY E.Room
						   ORDER BY E.Room, E.Start "; //needs limit clause

		if ($result = mysqli_query($con, $sql_check)) {

			$result_set = array();
            if (mysqli_num_rows($result) >= 1) {
                  while ($row = mysqli_fetch_row($result)) {
                  //capture events into string
                  $result_set[] = array('id' => $row[0], 'name' => $row[1], 'start' => $row[2], 'end' => $row[3], 'room' => $row[4]);
                }

                include($bldg_exec);

                /* free result set */
                mysqli_free_result($result);

                } else {
                    //default
                    $input = __DIR__ . "/theme/{$theme}/images/default-vertical.png";
                    $output = __DIR__ . "/images/". strtolower($b) .".png";
                    file_put_contents($output, file_get_contents($input));
                }
			}
		}
	}
 }

mysqli_close($con);
