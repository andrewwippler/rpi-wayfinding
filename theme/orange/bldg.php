<?php

		
		$y = 550;
		if (isset($result_set[0])) {
            
		$im = @imagecreatefromjpeg($vertimg);
	
$text_color = imagecolorallocate($im, 228, 34, 34);
$gray_color = imagecolorallocate($im, 115, 115, 115);
	/* See if it failed */
	if($im) {
		
		
			foreach($result_set as $bi) {

		$group_time = date("g:iA",strtotime($bi["start"])) . " - " . date("g:iA",strtotime($bi["end"]));
		$event_sub = substr($bi['name'], 0, 45);
	
					//room first
					$x = 20;
					$y = $y + 60; // from above. Marker is at bottom of text.

					// Write it
					imagettftext($im, 20, 0, $x, $y, $text_color, $bldgfont, preg_replace('/-/', ' ',$bi['room']));

					//Event subject
					$x = $x + 155;				
					imagettftext($im, 20, 0, $x, $y, $text_color, $bldgfont, $event_sub);		
					
					//time
					$x = $x + 650;
					imagettftext($im, 20, 0, $x, $y, $gray_color, $bottom_font, $group_time);
				}
					$file = $_SERVER["DOCUMENT_ROOT"] . "/images/" . strtolower($b). ".jpg";


				// Save the image 
				imagejpeg($im, $file);
		
// Free up memory
			imagedestroy($im);
}

}
?>
