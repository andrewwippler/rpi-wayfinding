<?php
/* 
 * This file contains the rooms you want to pull in
 *
 * Copy the below paste to the bottom of the page to add a new room.
	$rooms[] = array(
		'name' => 'test',
		'type' => '1', //1 = exchange room resource, 2 = planning center RSS
		'logon_name' => '', //for room
		'pass' => '', //for room
		'url' => '', //for planning center
		);
 */

$rooms = array();

$rooms[] = array(
		'name' => 'test',
		'type' => 1, //1 = exchange room resource, 2 = planning center RSS
		'logon_name' => '', //for exchange room
		'pass' => '', //for exchange room
		'url' => '', //planning center/google calendar
		);
