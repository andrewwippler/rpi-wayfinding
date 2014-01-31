<?php

		
		$y = 550;
		if (isset($result_set[0])) {
    switch ($group) {
        case "revels-first-floor":        
		$im = @imagecreatefromjpeg($vertimg);
        break;
        case "revels-second-floor":        
		$im = @imagecreatefromjpeg($vertimg2);
        break;
        case "revels-third-floor":        
		$im = @imagecreatefromjpeg($vertimg3);
        break;
        default:        
		$im = @imagecreatefromjpeg($vertimg);
        break;
	} 
	
$text_color = imagecolorallocate($im, 228, 34, 34);
$gray_color = imagecolorallocate($im, 115, 115, 115);
	/* See if it failed */
	if($im) {
		
		
			foreach($result_set as $gi) {

		$group_time = date("g:iA",strtotime($gi["start"])) . " - " . date("g:iA",strtotime($gi["end"]));
		$event_sub = substr($gi['name'], 0, 45);
	
					//room first
					$x = 20;
					$y = $y + 60; // from above. Marker is at bottom of text.

					// Write it
					imagettftext($im, 20, 0, $x, $y, $text_color, $groupfont, preg_replace('/-/', ' ',$gi['room']));

					//Event subject
					$x = $x + 155;				
					imagettftext($im, 20, 0, $x, $y, $text_color, $groupfont, $event_sub);		
					
					//time
					$x = $x + 650;
					imagettftext($im, 20, 0, $x, $y, $gray_color, $bottom_font, $group_time);
				}
					$file = $_SERVER["DOCUMENT_ROOT"] . "/images/" . strtolower($group). ".jpg";


				// Save the image 
				imagejpeg($im, $file);
		
// Free up memory
			imagedestroy($im);
}

}
?>
