<?php
function getSpecificEvent($eventid) {
    global $database;
    $event = $database->get('events', '*', ['id' => $eventid]);
    foreach($event as $key=>$value) {
        $page .= "<p>" . $key . ":" . $value . "</p>";
    }
    Page::write($page);
}
?>
