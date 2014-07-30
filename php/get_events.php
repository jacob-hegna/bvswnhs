<?php
require('config.php');
require('medoo.min.php');

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'bvswnhs',
    'server' => SERVER_IP,
    'username' => SERVER_USER,
    'password' => SERVER_PASS]);

$events = array();

foreach($database->select('events', '*') as $i) {
    $events[] = array(
        'id' => $i['id'],
        'title' => $i['name'],
        'class' => 'event-important',
        'start' => (strtotime($i['date']) . '000')
    );
}
echo json_encode(array(
    'success' => 1,
    'result'  => $events
));
?>