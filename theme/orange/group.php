<?php

		
		$y = 550;
		if (isset($result_set[0])) {
    switch ($group) {
        case "revels-first-floor":        
		$im = @imagecreatefrompng($vertimg,NULL,0);
        break;
        case "revels-second-floor":        
		$im = @imagecreatefrompng($vertimg2,NULL,0);
        break;
        case "revels-third-floor":        
		$im = @imagecreatefrompng($vertimg3,NULL,0);
        break;
        default:        
		$im = @imagecreatefrompng($vertimg,NULL,0);
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
					$file = $_SERVER["DOCUMENT_ROOT"] . "/images/" . strtolower($group). ".png";


				// Save the image 
				imagepng($im, $file);
		
// Free up memory
			imagedestroy($im);
}

}
?>
