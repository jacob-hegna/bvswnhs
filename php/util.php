<?php
class Util {
    public static function emailBlast($attr) {
        global $database;
        foreach($database->select('members', '*') as $i) {
            mail($i['email'], $attr['subject'], $attr['message']);
        }
    }

    public static function formatPhoneNum($num) {
        return return "(" . substr($num, 0, 3) . ") " . substr($num, 3, 3) . "-" . substr($num, 6, 4);
    }

    public static function get_cal_events() {
        global $database;
        $events = array();
        foreach($database->select('events', '*') as $i) {
            $events[] = array(
                'id' => $i['id'],
                'title' => $i['name'],
                'class' => 'event-important',
                'start' => (strtotime($i['date']) . '000')
            );
        }
        return json_encode($events);
    }

    public static function getUser($id) {
        global $database;
        return $database->get('members', '*', ['bvid' => $id]);
    }

    // current user
    public static function getCUser() {
        global $database;
        return Util::getUser($_SESSION['bvid']);
    }

    public static function sign_in($bvid) {
        global $database;

        if($database->has('members', ['bvid' => $bvid])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['bvid'] = $bvid;
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    public static function add_event($attr) {
        global $database;
        $database->insert('events', [
            'name' => $attr['name'],
            'hours' => $attr['hours'],
            'date' => $attr['date']
        ]);
    }

    public static function remove_event($id) {
        global $database;
        $members = json_decode($database->get('events', 'members', ['id' => $id]));
        foreach($members as $bvid) {
            $updated_events = array_diff(json_decode($database->get('members', 'events', ['bvid' => $bvid])), array($id));
            $database->update('members', ['events' => json_encode($updated_events)], ['bvid' => $bvid]);
        }
        $database->delete('events', ['id' => $id]);
    }

    public static function join_event($id) {
        global $database;
        $events = json_decode($database->get('members', 'events', ['bvid' => $_SESSION['bvid']]));
        if(!in_array($id, $events)) { //Only if not already subscribed
            $events[] = $id;
            $database->update('members', ['events' => json_encode($events)], ['bvid' => $_SESSION['bvid']]);
            //Also add to list of members on event database
            $members = json_decode($database->get('events', 'members', ['bvid' => $_SESSION['bvid']]));
            $members[] = $_SESSION['bvid'];
            $database->update('events', ['members' => json_encode($members)], ['id' => $id]);
        }
    }

    public static function add_user($attr) {
        global $database;
        $database->insert('members', [
            'name' => $attr['name'],
            'email' => $attr['email'],
            'phone' => $attr['phone'],
            'hours' => $attr['hours'],
            'bvid' => $attr['bvid']
        ]);
    }

    public static function remove_user($id) {
        global $database;
        $database->delete('members', ['bvid' => $id]);
    }

    public static function getRank($rankNum) {
        $rankStr;
        switch ($rankNum) {
            case 0:
                $rankStr = "Member";
                break;
            case 1:
                $rankStr = "Officer";
                break;
            case 2:
                $rankStr = "Site Admin";
                break;
            default:
                $rankStr = "N/A";
                break;
        }
        return $rankStr;
    }

}
?>