<?php
 
function __autoload($class_name)
{
    // Start from the base path and determine the location from the class name,
    $base_path = '/php-ews';
    $include_file = $base_path . '/' . str_replace('_', '/', $class_name) . '.php';
 
    return (file_exists($include_file) ? require_once $include_file : false);
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

$today = date('Y-m-d');
 
$request->CalendarView->StartDate = $today . 'T00:00:01'; // an ISO8601 date e.g. 2012-06-12T15:18:34+03:00
$request->CalendarView->EndDate = $today . 'T23:59:59' ;// an ISO8601 date later than the above
 
// Only look in the "calendars folder"
$request->ParentFolderIds = new EWSType_NonEmptyArrayOfBaseFolderIdsType();
$request->ParentFolderIds->DistinguishedFolderId = new EWSType_DistinguishedFolderIdType();
$request->ParentFolderIds->DistinguishedFolderId->Id = EWSType_DistinguishedFolderIdNameType::CALENDAR;
 
// Send request
$response = $ews->FindItem($request);
 
// Loop through each item if event(s) were found in the timeframe specified
if ($response->ResponseMessages->FindItemResponseMessage->RootFolder->TotalItemsInView > 0){
    $events = $response->ResponseMessages->FindItemResponseMessage->RootFolder->Items->CalendarItem;
    foreach ($events as $event){
        $id = $event->ItemId->Id;
        $change_key = $event->ItemId->ChangeKey;
        $start = $event->Start;
        $end = $event->End;
        $subject = $event->Subject;
        $location = $event->Location;
      
    //TODO: insert into database
    //strip FW: from subject lines.
   
        echo ' Start=' . $start. ' End=' . $end. 'Subject =' . $subject . 'Location =' . $location . '<br />';
    }
}
else {
    // No items returned
}
?>
