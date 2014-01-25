<?php
/* 
 * This file is intended to set up general settings to access rooms and include additional rooms.
 *
 */

require("rooms.php");

//Start time to blank screens 
$start_time = "23:01";//11:01 pm

//End of blanking time
$end_time = "5:59";

//Exchange server
$mailserver = "";

//sql server settings
$sql_server = "";
$sql_username = "";
$sql_password = "";

//passcode for force sync
$passcode = "";
$force = FALSE; // leave false

//theme config
include("theme_settings.php");
