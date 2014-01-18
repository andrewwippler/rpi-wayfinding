<?php

		
		$y = 220;
		if (isset($result_set[0])) {
		$im = @imagecreatefromjpeg($vertimg);
	
	$black = imagecolorallocate($im, 0, 0, 0);
	$white = imagecolorallocate($im, 255, 255, 255);
	/* See if it failed */
	if($im) {
		
		
			foreach($result_set as $gi) {

		$group_time = date("g:i a",strtotime($gi["start"])) . " - " . date("g:i a",strtotime($gi["end"]));
		$event_sub = substr($gi['name'], 0, 58);
	
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

}
?>
