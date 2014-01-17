<?php

/* 
 * This file is intended to pull every room resource and place them in jpg files.
 * The end result is /images/<room_name_location>.jpg
 */
function __autoload($class_name)
{
    // Start from the base path and determine the location from the class name,
    $base_path = 'php-ews';
    $include_file = $base_path . '/' . str_replace('_', '/', $class_name) . '.php';
 
    return (file_exists($include_file) ? require_once $include_file : false);
}
require("settings.php");

$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s\n". mysqli_connect_error());

foreach($rooms as $r) {

//create daily events
if ($r['type'] == 1) {

include(__DIR__ . '/connectors/exchange.php');

} else if ($r['type'] == 2) {

include(__DIR__ . '/connectors/planning-center.php');

} else if ($r['type'] == 3) {

include(__DIR__ . '/connectors/google-calendar.php');

} else {

//you need to make your own code.

}

}
mysqli_close($con);

//todo: add optional mail to recipient when completed.

