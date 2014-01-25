<?php
 /* 
 * This file is intended to check an exchange calendar via ews
 * 
 */


$today = date('Y-m-d');

if ($force == TRUE) {
	$time = 'T'.date('H:i:sP');

} else {
	$time = 'T00:00:01'.date('P');
}
 
$ews = new ExchangeWebServices($mailserver, $r['logon_name'], $r['pass']);
 
// Set init class
$request = new EWSType_FindItemType();
 
// Use this to search only the items in the parent directory in question or use ::SOFT_DELETED
// to identify "soft deleted" items, i.e. not visible and not in the trash can.
$request->Traversal = EWSType_ItemQueryTraversalType::SHALLOW;
// This identifies the set of properties to return in an item or folder response
$request->ItemShape = new EWSType_ItemResponseShapeType();
$request->ItemShape->BaseShape = EWSType_DefaultShapeNamesType::DEFAULT_PROPERTIES;
 
// Define the timeframe to load calendar items
$request->CalendarView = new EWSType_CalendarViewType();

$request->CalendarView->StartDate = $today . $time; // an ISO8601 date e.g. 2012-06-12T15:18:34+03:00
$request->CalendarView->EndDate = $today . 'T23:59:59'.date('P');// an ISO8601 date later than the above
 
// Only look in the "calendars folder"
$request->ParentFolderIds = new EWSType_NonEmptyArrayOfBaseFolderIdsType();
$request->ParentFolderIds->DistinguishedFolderId = new EWSType_DistinguishedFolderIdType();
$request->ParentFolderIds->DistinguishedFolderId->Id = EWSType_DistinguishedFolderIdNameType::CALENDAR;
 
// Send request
$response = $ews->FindItem($request);
 
// Loop through each item if event(s) were found in the timeframe specified
if ($response->ResponseMessages->FindItemResponseMessage->RootFolder->TotalItemsInView > 0){
    $events = $response->ResponseMessages->FindItemResponseMessage->RootFolder->Items;
    foreach ($events as $event){
        $start = date('Y-m-d H:i:s',strtotime($event->Start));
        $end = date('Y-m-d H:i:s',strtotime($event->End));
        $subject = $event->Subject;
              
    //room resource delegation fix
    $subject = str_replace("FW: ", "", $subject);
    $subject = str_replace("\n", "", $subject);
    $subject = trim($subject);
   
   
		if ($subject != "") {
			//assuming still connected to database
			$query = "INSERT INTO events (EventName, Start, End, Room, Grp, Bldg) VALUES (?,?,?,?,?,?)";
			$stmt = mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt, "ssssss", $subject, $start, $end, $r['name'], $r['group'], $r['bldg']);
			/* Execute the statement */
			mysqli_stmt_execute($stmt);
		}
    }
}
else {
    // No items returned
}
?>
