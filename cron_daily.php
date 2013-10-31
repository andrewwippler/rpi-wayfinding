<?php

/* 
 * This file is intended to pull every room resource and place them in jpg files.
 * The end result is /images/<room_name_location>.jpg
 */

require("settings.php");

foreach($rooms as $r) {



//create image by connecting to respective item
if ($r['type'] == 1) {

include('exchange.php');

} else if ($r['type'] == 2) {

include('planning-center.php');

} else {

//you need to make your own code.

}

}


