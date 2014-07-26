<?php
error_reporting(-1);
ini_set('display_errors', 'Off');

session_start();

require('config.php');
require('medoo.min.php');
require('util.php');
require('pages/class.Page.php');
require('pages/error.php');
require('pages/members.php');
require('pages/events.php');
require('pages/home.php');
require('pages/profile.php');

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
			if($_SESSION['loggedin']) {
				get_profile();
			} else {
				get_home();
			}
			break;
		case 'profile':
			if($_SESSION['loggedin']) {
				get_profile();
			} else {
				get_error(403);
			}
			break;
		case 'events':
			if($_SESSION['loggedin']) {
				get_events();
			} else {
				get_error(403);
			}
            break;
        case 'members':
            if($_SESSION['loggedin']) {
                if(Util::getUser($_SESSION['bvid'])['rank'] == 2) {
                    get_members();
                } else {
                    get_error(403);
                }
            } else {
                get_error(403);
            }
            break;
        default:
            get_error(404);
            break;
	}
} else if(array_key_exists('util', $_POST)) {
	switch($_POST['util']) {
		case 'sign_in':
			Util::sign_in($_POST['attr']['bvid']);
			break;
		case 'sign_out':
            session_unset();
            session_destroy();
            $_SESSION['loggedin'] = false;
            echo 'refresh';
            break;
	}
}
?>
