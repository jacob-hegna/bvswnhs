<?php
require('medoo.min.php');
require('util.php');

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'bvswdebate',
    'server' => SERVER_IP,
    'username' => SERVER_USER,
    'password' => SERVER_PASS]);

if(array_key_exists('bvid', $_POST)) {
    echo Util::getUser($_POST['bvid'])['hours'];
}
?>