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

//demensions
$ix = 1920;
$iy = 1080;
$gix = 1080;
$giy = 1920;
$bix = 1080;
$biy = 1920;

// Path to our font file
$font = __DIR__ . "/font/aleo-bold.ttf";
$bottom_font = __DIR__ . "/font/aleo-bold.ttf";
$groupfont = __DIR__ . "/font/aleo-bold.ttf";
$bldgfont = __DIR__ . "/font/aleo-bold.ttf";

//horizontal image
$horizim = __DIR__ . "/images/blanks/rpiw-blank-horizontal.jpg";
$vertimg = __DIR__ . "/images/blanks/rpiw-blank-vertical.jpg";
