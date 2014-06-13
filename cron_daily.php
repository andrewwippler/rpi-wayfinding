<?php

/* 
 * This file is intended to pull every room resource and place them in jpg files.
 * The end result is /images/<room_name_location>.jpg
 */
 $email_time = microtime(true);
 function __autoload($class_name)
{
    // Start from the base path and determine the location from the class name,
    $base_path = 'php-ews';
    $include_file = $base_path . '/' . str_replace('_', '/', $class_name) . '.php';
  echo $include_file . "<br />";
    return (file_exists($include_file) ? require_once $include_file : false);
} 


require_once('php-ews/ExchangeWebServices.php');
require_once('php-ews/EWSType.php');
require_once('php-ews/NTLMSoapClient.php');
require_once('php-ews/EWSType/FindItemType.php');
require_once('php-ews/EWSType/ItemQueryTraversalType.php');
require_once('php-ews/EWSType/ItemResponseShapeType.php');
require_once('php-ews/EWSType/DefaultShapeNamesType.php');
require_once('php-ews/EWSType/CalendarViewType.php');
require_once('php-ews/EWSType/NonEmptyArrayOfBaseFolderIdsType.php');
require_once('php-ews/EWSType/DistinguishedFolderIdType.php');
require_once('php-ews/EWSType/DistinguishedFolderIdNameType.php');
require_once('php-ews/NTLMSoapClient/Exchange.php');



require("settings.php");

$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s\n". mysqli_connect_error());

foreach($rooms as $r) {

//create daily events
if ($r['type'] == 1) {

include('exchange.php');

} else if ($r['type'] == 2) {

include('planning-center.php');

} else if ($r['type'] == 3) {

include('google-calendar.php');

} else {

//you need to make your own code.

}

}

//include cleaning function
include('clean.php');

mysqli_close($con);

if ($finish_email == TRUE) {
	
	
	$email_message = "
	<html>
	<body>
	The execution of RPi-Wayfinding has completed on {$_SERVER["SERVER_NAME"]} ({$_SERVER["SERVER_ADDR"]}). 
	<br/>
	<br />
	The request took ".(microtime(true) - $email_time)." seconds.
	</body>
	</html>	
	";
	
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=iso-8859-1";
	$headers[] = "From: RPi-Wayfinding <{$email_to}>";
	$headers[] = "Subject: {$email_subject}";
	$headers[] = "X-Mailer: PHP/".phpversion();
	
	mail($email_to, $email_subject, $email_message, implode("\r\n", $headers));
	
}
