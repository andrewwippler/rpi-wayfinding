
<?php
//550 is mid of 1080
//1000 is bottom part
$mainevent_time = date("g:i a",strtotime($mainevent["start"])) . " - " . date("g:i a",strtotime($mainevent["end"]));
$secevent_time = date("g:i a",strtotime($secevent["start"])) . " - " . date("g:i a",strtotime($secevent["end"]));

$im = imagecreatetruecolor($ix, $iy);
$black = imagecolorallocate($im, 0, 0, 0);
$white = imagecolorallocate($im, 255, 255, 255);

 /* Attempt to open */
    $im = @imagecreatefromjpeg($horizim);

    /* See if it failed */
    if(!$im)
    {
        /* Create a black image */
        $im  = imagecreatetruecolor($ix, $iy);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, $ix, $iy, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $horizim, $tc);
    } else {

	$eventtext = wordwrap($mainevent['name'], 45, "\n");


	if (strlen($eventtext) > 45) {

		$newtext = explode("\n", $eventtext);
		
		// First we create our bounding box for the first text
		$bbox = imagettfbbox(60, 0, $font, $newtext[0]);

		// This is our cordinates for X and Y
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
		$y = 514 - 14; // middle of screen, bump up  14px

		// Write it
		imagettftext($im, 60, 0, $x, $y, $black, $font, $newtext[0]);
		
		// First we create our bounding box for the second text
		$bbox = imagettfbbox(60, 0, $font, $newtext[1]);

		// This is our cordinates for X and Y
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
		$y = $y + 96; // add font size + 24px

		// Write it
		imagettftext($im, 60, 0, $x, $y, $black, $font, $newtext[1]);
		
		// Create the next bounding box for the second text
		$bbox = imagettfbbox(48, 0, $font, $mainevent_time);

		// Set the cordinates so its next to the first text
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
		$y = $y + 82; //add font size + 10px for spacing

		// Write it
		imagettftext($im, 48, 0, $x, $y, $black, $font, $mainevent_time);

	} else {
		
		// First we create our bounding box for the first text
		$bbox = imagettfbbox(60, 0, $font, $eventtext);

		// This is our cordinates for X and Y
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
		$y = 550 - 10; // middle of screen, bump up  10px

		// Write it
		imagettftext($im, 60, 0, $x, $y, $black, $font, $eventtext);

		// Create the next bounding box for the second text
		$bbox = imagettfbbox(48, 0, $font, $mainevent_time);

		// Set the cordinates so its next to the first text
		$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
		$y = 550 + 82; //middle of screen + above text size + 10px for spacing

		// Write it
		imagettftext($im, 48, 0, $x, $y, $black, $font, $mainevent_time);
		
	}

	if ($two_events == TRUE) {
	$str = substr($secevent['name'], 0, 84);//84 characters is good

	// First we create our bounding box for the first text
	$bbox = imagettfbbox(36, 0, $bottom_font, $str);

	// This is our cordinates for X and Y
	$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
	$y = 1000 - 5; // bottom part, bump up  5px

	// Write it
	imagettftext($im, 36, 0, $x, $y, $black, $bottom_font, $str);

	// Create the next bounding box for the second text
	$bbox = imagettfbbox(24, 0, $bottom_font, $secevent_time);

	// Set the cordinates so its next to the first text
	$x = $bbox[0] + (imagesx($im) / 2) - ($bbox[4] / 2);
	$y = 1000 + 41; //middle of screen + above text size + 5px for spacing

	// Write it
	imagettftext($im, 24, 0, $x, $y, $black, $bottom_font, $secevent_time);

	}

	$file = __DIR__ . "/images/".strtolower($mainevent['room']).".jpg";

	// Save the image 
	imagejpeg($im, $file);

}

// Free up memory
imagedestroy($im);


