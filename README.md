# rpi-wayfinding

PHP application for wayfinding using a Raspberry Pi and an HDMI monitor. Currently supports pulling information from an exchange calendar and google calendar (via json).

Alternate usage: Big monitor with daily task list for everyone to see.

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
 
## TODO:

- Special names for groups and buildings
- Create easy install

## Install:

#### Webserver

```
sudo apt-get install apache2-common php5-mysql php5-gd php5-curl
```

```
# cd /var/
# git clone https://github.com/andrewwippler/rpi-wayfinding.git www
``` 

##### Crontab:

```
crontab -e
```

Contents:

```
1 0 * * * curl --silent --compressed http://localhost/cron_daily.php
1,16,31,46 * * * * curl --silent --compressed  http://localhost/cron_regularly.php
```

##### MySQL

```
CREATE DATABASE IF NOT EXISTS rpiwayfinding;
CREATE USER 'wayfinding'@'localhost' IDENTIFIED BY 'some_pass';
GRANT ALL PRIVILEGES ON rpiwayfinding.* TO 'wayfinding'@'localhost';
USE rpiwayfinding;
CREATE TABLE IF NOT EXISTS events (PID INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(PID),EventName TEXT,Start DATETIME,End DATETIME,Room TEXT,Grp TEXT,Bldg TEXT);
```

##### Final steps

1. Edit rooms.php
2. Edit settings.php

#### RPi


```
sudo apt-get install feh
```

##### Create shell script

```
touch /home/pi/rpi-wayfinding.sh
chmod +x /home/pi/rpi-wayfinding.sh
nano /home/pi/rpi-wayfinding.sh
```

Contents (where *BOLD* is the same as inside rooms.php):

```
#!/bin/sh

feh -k --hide-pointer -F -R 1200 http://webserver/image.php?i=*RPI* &
```

For a group (floor level) sign:

```
#!/bin/sh

feh -k --hide-pointer -F -R 1200 http://webserver/image.php?g=*GROUPNAME* &
```

For a building (lobby) sign:

```
#!/bin/sh

feh --hide-pointer -F -R 1200 http://webserver/image.php?b=*BLDGNAME* &
```

##### Create autorun on start

```
mkdir /home/pi/.config/autostart
nano /home/pi/.config/autostart/rpi-wayfinding.desktop
```

Contents:

```
[Desktop Entry]
Type=Application
Exec=/home/pi/rpi-wayfinding.sh
```
Note: Extra spaces at the end of thi file will cause feh to not load on start.

##### Rotating the RPi for group/building screens

1 = 90* clockwise
3 = 270* clockwise (90* counter-clockwise)

```
# echo display_rotate=1 >> /boot/config.txt
```

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
		'name' => 'US Holidays', //Use - instead of spaces. This is case-sensitive and will display as-is on group and building signs.
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

//demensions - these are for 1080p monitors
$ix = 1920;
$iy = 1080;
$gix = 1080;
$giy = 1920;
$bix = 1080;
$biy = 1920;

// Path to our font file for items
$font = __DIR__ . "/font/aleo-bold.ttf";
$bottom_font = __DIR__ . "/font/aleo-bold.ttf";
$groupfont = __DIR__ . "/font/aleo-bold.ttf";
$bldgfont = __DIR__ . "/font/aleo-bold.ttf";

//background images
$horizim = __DIR__ . "/images/blanks/rpiw-blank-horizontal.jpg";
$vertimg = __DIR__ . "/images/blanks/rpiw-blank-vertical.jpg";
```

## Getting the google calender URL

1. Make the calendar public
2. View the calendar settings
3. Copy the calendar ID and place it in the url string of the room.
