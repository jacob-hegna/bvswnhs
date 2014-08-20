<?php
error_reporting(-1);
ini_set('display_errors', 'Off');

session_start();

require('config.php');
require('medoo.min.php');
require('util.php');
require('sendMail.php');
require('pages/class.Page.php');
require('pages/error.php');
require('pages/members.php');
require('pages/eventdetails.php');
require('pages/events.php');
require('pages/meetings.php');
require('pages/calendar.php');
require('pages/blast.php');
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
                getProfile();
            } else {
                getHome();
            }
            break;
        case 'profile':
            if($_SESSION['loggedin']) {
                getProfile();
            } else {
                getError(403);
            }
            break;
        case 'events':
            if($_SESSION['loggedin']) {
                if(array_key_exists('id', $_POST['attr'])) {
                    getSpecificEvent($_POST['attr']['id']);
                } else {
                    getEvents();
                }
            } else {
                getError(403);
            }
            break;
        case 'meetings':
            if($_SESSION['loggedin']) {
                getMeetings();
            } else {
                getError(403);
            }
            break;
        case 'calendar':
            if($_SESSION['loggedin']) {
                getCal();
            } else {
                getError(403);
            }
            break;
        case 'members':
            if($_SESSION['loggedin']) {
                if(Util::getCUser()['rank'] >= 1) {
                    getMembers();
                } else {
                    getError(403);
                }
            } else {
                getError(403);
            }
            break;
        case 'blast':
            if($_SESSION['loggedin']) {
                if(Util::getCUser()['rank'] >= 1) {
                    getBlast();
                } else {
                    getError(403);
                }
            } else {
                getError(403);
            }
            break;
        default:
            getError(404);
            break;
    }
} else if(array_key_exists('util', $_POST)) {
    switch($_POST['util']) {
        case 'edit_sql': /* expose sql tables via ajax #NoRagrets2012 */
            if(Util::getCUser()['rank'] >= 1) {
                $database->update($_POST['attr']['table'], [$_POST['attr']['column'] => $_POST['attr']['new']],
                    ['id' => $_POST['attr']['id']]);
            }
            break;
        case 'cal_events':
            echo Util::getCalEvents();
            break;
        case 'add_event':
            if(Util::getCUser()['rank'] >= 1) {
                Util::addEvent($_POST['attr']);
            }
            break;
        case 'remove_event':
            if(Util::getCUser()['rank'] >= 1) {
                Util::removeEvent($_POST['attr']['id']);
            }
            break;
        case 'add_meeting':
            if(Util::getCUser()['rank'] >= 1) {
                Util::addMeeting($_POST['attr']);
            }
            break;
        case 'remove_meeting':
            if(Util::getCUser()['rank'] >= 1) {
                Util::removeMeeting($_POST['attr']['id']);
            }
            break;
        case 'join_event':
            Util::joinEvent($_POST['attr']['id']);
            break;
        case 'leave_event':
            Util::leaveEvent($_POST['attr']['id']);
            break;
        case 'add_user':
            if(Util::getCUser()['rank'] >= 1) {
                Util::addUser($_POST['attr']);
            }
            break;
        case 'remove_user':
            if(Util::getCUser()['rank'] >= 1) {
                Util::removeUser($_POST['attr']['id']);
            }
            break;
        case 'email_blast':
            if(Util::getCUser()['rank'] >= 1) {
                Util::emailBlast($_POST['attr']);
            }
            break;
        case 'sign_in':
            Util::signIn($_POST['attr']['bvid']);
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
