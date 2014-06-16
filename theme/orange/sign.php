
<?php
$mainevent_time = date("g:iA",strtotime($mainevent["start"]));
$secevent_time = date("g:iA",strtotime($secevent["start"]));

$im = imagecreatetruecolor($ix, $iy);
$text_color = imagecolorallocate($im, 228, 34, 34);
$gray_color = imagecolorallocate($im, 115, 115, 115);
$text_colord = imagecolorallocate($im, 241, 138, 138);
$gray_colord = imagecolorallocate($im, 189, 189, 189);

 /* Attempt to open */
    $im = @imagecreatefrompng($horizim);

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

    //to prevent subjects that contain "| theme", use $filtered[0]
	$eventtext = wordwrap($filtered[0], 28, "\n");
    $filtered2 = explode("|",$secevent['name']);
    $eventtext2 = wordwrap($filtered2[0], 35, "\n");
    $x = 620;
    
    	if ($two_events == TRUE) {
            
            //check lengths
            if (strlen($eventtext) > 30) {
                $newtext = explode("\n", $eventtext);
                //position correctly
                $y = 250;
                            
                //write it
                imagettftext($im, 60, 0, $x, $y, $text_color, $font, $newtext[0]);
                
                //second line
                $y = $y + 72;
                
                imagettftext($im, 60, 0, $x, $y, $text_color, $font, $newtext[1]);
                $y = $y + 72; //add font size + 10px for spacing

                // Write it
                imagettftext($im, 48, 0, $x, $y, $gray_color, $bottom_font, $mainevent_time);
                
            } else {
                //position correctly
                $y = 350;
                                        
                //write it
                imagettftext($im, 60, 0, $x, $y, $text_color, $font, $eventtext);
                $y = $y + 72; //add font size + 10px for spacing

                // Write it
                imagettftext($im, 48, 0, $x, $y, $gray_color, $bottom_font, $mainevent_time);
                
            }
            
            if (strlen($eventtext2) > 38) {
                $newtext2 = explode("\n", $eventtext2);
                //position correctly
                $y = 705;
                            
                //write it
                imagettftext($im, 48, 0, $x, $y, $text_colord, $font, $newtext2[0]);
                
                //second line
                $y = $y + 60;
                
                imagettftext($im, 48, 0, $x, $y, $text_colord, $font, $newtext2[1]);
                $y = $y + 50; //add font size + 10px for spacing

                // Write it
                imagettftext($im, 32, 0, $x, $y, $gray_colord, $bottom_font, $secevent_time);
            

            } else {
                //position correctly
                $y = 755;
                                        
                //write it
                imagettftext($im, 48, 0, $x, $y, $text_colord, $font, $eventtext2);
                $y = $y + 48; //add font size + 10px for spacing

                // Write it
                imagettftext($im, 32, 0, $x, $y, $gray_colord, $bottom_font, $secevent_time);       
            
            }

	} else {
        //only one event

        if (strlen($eventtext) > 30) {
                $newtext = explode("\n", $eventtext);
                //posi
                $y = 500;
                            
                //write it
                imagettftext($im, 60, 0, $x, $y, $text_color, $font, $newtext[0]);
                
                //second line
                $y = $y + 72;
                
                imagettftext($im, 60, 0, $x, $y, $text_color, $font, $newtext[1]);
                $y = $y + 72; //add font size + 10px for spacing

                // Write it
                imagettftext($im, 48, 0, $x, $y, $gray_color, $bottom_font, $mainevent_time);
            } else {
                //position correctly
                $y = 540;
                                        
                //write it
                imagettftext($im, 60, 0, $x, $y, $text_color, $font, $eventtext);
                $y = $y + 62; //add font size + 10px for spacing

                // Write it
                imagettftext($im, 48, 0, $x, $y, $gray_color, $bottom_font, $mainevent_time);         
            
        }

    }

	$file = $_SERVER["DOCUMENT_ROOT"] .  "/images/".strtolower($mainevent['room']).".png";

	// Save the image 
	imagepng($im, $file);

}

// Free up memory
imagedestroy($im);


