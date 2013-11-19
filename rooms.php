<?php
/* 
 * This file contains the rooms you want to pull in
 *
 * Copy the below paste to the bottom of the page to add a new room.
	$rooms[] = array(
		'name' => 'test',
		'type' => 1, //1 = exchange room resource, 2 = planning center RSS
		'logon_name' => '', //for exchange room
		'pass' => '', //for exchange room
		'url' => '', //planning center/google calendar
		'group' => '', //first floor, building-first-floor, etc.
		'rpi' => array ('test-sign-1','test-sign-2',), //place your hostnames here
		);
 */

$rooms = array();

$rooms[] = array(
		'name' => 'test',
		'type' => 1, //1 = exchange room resource, 2 = planning center RSS
		'logon_name' => '', //for exchange room
		'pass' => '', //for exchange room
		'url' => '', //planning center/google calendar
		'group' => '', //first floor, building-first-floor, etc.
		'rpi' => array ('test-sign-1','test-sign-2',), //place your hostnames here
		);
