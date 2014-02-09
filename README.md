# RPi-Wayfinding 0.6.2b

RPi-Wayfinding is a PHP application for dynamic digital wayfinding using a Raspberry Pi and an HDMI monitor. Currently supports pulling information from an exchange calendar (via EWS) and google calendar (via json).

Alternate usage: Big monitor with daily calendar event list for everyone to see.

RPi Wayfinding is now in BETA. Please test :)

[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=JXNSHZTBDNACS&lc=US&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted)

## Requirements

 * PHP 5.4+ - for webserver
 * PHP GD - for webserver
 * PHP FreeType - for webserver
 * MySQL 5.5+/MariaDB - for webserver
 * feh - for RPi
 * Puppet master (optional)
 * cURL with NTLM support (7.23.0+ recommended)
 * Exchange 2010 or 2013 - for Exchange Calendars
 * Public Google Calendar - for Google Calendar support
 
## TODO:

- Create easy install

Check the [wiki](https://github.com/andrewwippler/rpi-wayfinding/wiki) for more information.

## Examples

Rooms.php

```
<?php
$rooms[] = array(
		'name' => '101', //Use - instead of spaces. This is case-sensitive and will display as-is on group and building signs.
		'type' => 1, //1 = exchange room resource, 2 = planning center RSS, 3 = google calendar
		'logon_name' => 'adm101', //for exchange room
		'pass' => 'simple pass', //for exchange room
		'url' => '', //planning center/google calendar
		'group' => 'Administrative-First-Floor', //first floor, building-first-floor, etc.
		'rpi' => array ('adm101','admin-101','rpi-admin-101-a','rpi-admin-101-b'), //place whatever you want the URI i to grab here. 
		'bldg' => 'Administrative', //do not leave emtpy
		);
		
$rooms[] = array(
		'name' => 'US-Holidays', //Use - instead of spaces. This is case-sensitive and will display as-is on group and building signs.
		'type' => 3, //1 = exchange room resource, 2 = planning center RSS, 3 = google calendar
		'logon_name' => '', //for exchange room
		'pass' => '', //for exchange room
		'url' => 'en.usa#holiday@group.v.calendar.google.com', //planning center/google calendar
		'group' => 'holidays', //first floor, building-first-floor, etc.
		'rpi' => array ('rpi-holiday-screen',), //place whatever you want the URI i to grab here. 
		'bldg' => 'Happy-Holidays', //do not leave emtpy
		);		
```
settings.php

```
<?php
/* 
 * This file is intended to set up general settings to access rooms and include additional rooms.
 *
 */

require("rooms.php");

//Start time to black screens 
$start_time = "23:01";//11:01 pm

//End of black screen time
$end_time = "5:59";

//Exchange server of room resources
$mailserver = "";

//sql server settings (filled in with install settings)
$sql_server = "localhost";
$sql_username = "wayfinding";
$sql_password = "some_pass";

//passcode for force sync
$passcode = "change_me_quick"; // http://localhost/force_sync.php?p=change_me_quick will delete all items from database and regenerate items beginning at current time.
$force = FALSE; // leave false

//theme config
include("theme_settings.php");

//email settings
$finish_email = FALSE;
$email_to = "root@localhost";
$email_subject = "RPi-wayfinding has done its daily task.";
```

