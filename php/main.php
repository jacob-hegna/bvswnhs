<?php
error_reporting(-1);
ini_set('display_errors', 'On');

require('medoo.min.php');
require('util.php');

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'bvswnhs',
    'server' => SERVER_IP,
    'username' => SERVER_USER,
    'password' => SERVER_PASS]);

if(array_key_exists('bvid', $_POST)) {
    echo $database->get('members', 'hours', ['bvid' => $_POST['bvid']]);
}
?>