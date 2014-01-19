<?php

		$y = 220;
		if (isset($result_set[0])) {
		$im = @imagecreatefromjpeg($vertimg);
	
	$black = imagecolorallocate($im, 0, 0, 0);
	$white = imagecolorallocate($im, 255, 255, 255);
	/* See if it failed */
	if($im) {
		
		
			foreach($result_set as $bi) {

		$bldg_time = date("g:i a",strtotime($bi["start"])) . " - " . date("g:i a",strtotime($bi["end"]));
		$event_sub = substr($bi['name'], 0, 58);
	
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
					$file =$_SERVER["DOCUMENT_ROOT"] . "/images/".$b.".jpg";

				// Save the image 
				imagejpeg($im, $file);
		
// Free up memory
			imagedestroy($im);
}

}
			
