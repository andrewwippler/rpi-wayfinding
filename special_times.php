<?php

/*
 * This file is intended to specify special times
 *
 * FORMAT: No spaces and no leading zeros
 * 
 * DAILY:
 * Start/End - 24hour format (i.e. 200, 350; 1230, 1500)
 * 
 * WEEKLY:
 * Start/End - 3 digit day and 24hour format (i.e. Mon1230, Mon1500; Sun1100, Sun2300)
 * 
 * MONTHLY:
 * Start/End - DayMonthHourMinute (i.e. 5Mar1230, 5Mar2400)
 * 
 * YEARLY:
 * Start/End - DayMonthYearHourMinute (i.e. 5Nov20141000,5Nov20141500)
 *
 */
$specialt = array();

$specialt[] = array(
				'name' => 'testing',
				'start' => '',//See above
				'end' => '',			
				'recurrence' => '',// 1 = daily, 2 = weekly on a single day, 3 = monthly, 4 = yearly
				'bldg' => '', //building to match | dont want this campus-wide
				'group' => '',
				);
