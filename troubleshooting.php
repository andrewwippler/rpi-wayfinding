<?php

require('settings.php');
$con=mysqli_connect($sql_server,$sql_username,$sql_password,"rpiwayfinding") or die("Connect failed: %s<br />". mysqli_connect_error());

echo "Checking for rooms...<br /><br />";
if (is_array($rooms[0]['name'])) { echo "Found first room: {$rooms[0]['name']}"; } else { echo "ERROR: No rooms found"; }

echo "<br /><br />";

echo "Checking events table...<br /><br />";

$sql_check = "SELECT * FROM events";
if ($result = mysqli_query($con, $sql_check)) {
echo "Found these results: <br />";

  while ($row = mysqli_fetch_row($result)) {
    echo "id: {$row[0]}, name: {$row[1]}, start: {$row[2]}, end: {$row[3]}, room: {$row[4]}<br />";
  }


} else {
echo "No results found in database.<br /><br />";
echo "Attempting to gather information from the first room listed...<br />";

$r = $rooms[0];

if ($r['type'] == 1) {
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
  include(__DIR__ . 'tests/exchange-test.php');

} else if ($r['type'] == 2) {

  include(__DIR__ . 'tests/planning-center-test.php');

} else if ($r['type'] == 3) {

  include(__DIR__ . 'tests/google-calendar-test.php');

} else {

//you need to make your own code.

}

}
