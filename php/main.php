<?php
error_reporting(-1);
ini_set('display_errors', 'On');

session_start();

require('config.php');
require('medoo.min.php');
require('util.php');
require('pages/home.php');

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'bvswnhs',
    'server' => SERVER_IP,
    'username' => SERVER_USER,
    'password' => SERVER_PASS]);

if(!array_key_exists('loggedin', $_SESSION)) {
    $_SESSION['loggedin'] = false;
}

if(array_key_exists('bvid', $_POST)) {
    echo Util::getUser($_POST['bvid'])['hours'];
}

if(array_key_exists('page', $_POST)) {
	switch($_POST['page']) {
		case 'home':
			get_home();
			break;
	}
}
?>
