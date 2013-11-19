rpi-wayfinding
==============

PHP application for wayfinding using a Raspberry Pi and an HDMI monitor. Currently supports pulling information from an exchange calendar and google calendar (via json).

Alternate usage: Big monitor with daily task list for everyone to see.

Requirements
-------------------------

 * PHP 5.4+ - for webserver
 * PHP GD - for webserver
 * PHP FreeType - for webserver
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
- ~~Create image~~
- Examples
- ~~Puppet module~~
- Create how to use without puppet master
- Complete cron_regularly - 80%
- Create install
- ~~Create force-sync~~
