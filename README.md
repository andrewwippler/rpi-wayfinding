rpi-wayfinding
==============

PHP application for wayfinding using a Raspberry Pi and an HDMI monitor. Currently supports pulling information from an exchange calendar and google calendar (via json).

Requirements
-------------------------

 * PHP 5.4+ - for webserver
 * PHP GD - for webserver
 * MySQL 5.5+/MariaDB - for webserver
 * feh - for RPi
 * Puppet master (optional)
 * cURL with NTLM support (7.23.0+ recommended)
 * Exchange 2010 or 2013 - for Exchange Calendars
 
TODO:
-------------------------

- Settings
- ~~Grab from exchange~~
- ~~Grab from google calendar~~
- Create image
- Save image
- Examples
- ~~Puppet module~~
- Create how to use without puppet master
- Complete cron_regularly
- Create install
- Create force-sync (right now it syncs daily)
