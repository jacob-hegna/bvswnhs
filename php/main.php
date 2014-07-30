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
require('pages/calendar.php');
require('pages/home.php');
require('pages/profile.php');

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'bvswnhs',
    'server' => SERVER_IP,
    'username' => SERVER_USER,
    'password' => SERVER_PASS]);

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo
'<html>
<body>
Fuckin\' clever, but this is off limits
</body>
</html>';
}

if(!array_key_exists('loggedin', $_SESSION)) {
    $_SESSION['loggedin'] = false;
}

if(array_key_exists('bvid', $_POST)) {
    echo Util::getUser($_POST['bvid'])['hours'];
}

if(array_key_exists('from', $_GET) && array_key_exists('to', $_GET)) {
    echo Util::get_cal_events();
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
        case 'calendar':
            if($_SESSION['loggedin']) {
                get_cal();
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
        case 'cal_events':
            Util::get_cal_events();
            break;
        case 'add_event':
            if(Util::getUser($_SESSION['bvid'])['rank'] >= 1) {
                Util::add_event($_POST['attr']);
            } else {
                get_error(403);
            }
            break;
        case 'remove_event':
            if(Util::getUser($_SESSION['bvid'])['rank'] >= 1) {
                Util::remove_event($_POST['attr']['id']);
            } else {
                get_error(403);
            }
            break;
        case 'join_event':
            Util::join_event($_POST['attr']['id']);
            break;
        case 'add_user':
            if(Util::getUser($_SESSION['bvid'])['rank'] >= 1) {
                Util::add_user($_POST['attr']);
            } else {
                get_error(403);
            }
            break;
        case 'remove_user':
            if(Util::getUser($_SESSION['bvid'])['rank'] >= 1) {
                Util::remove_user($_POST['attr']['id']);
            } else {
                get_error(403);
            }
            break;
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
