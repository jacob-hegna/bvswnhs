<?php
class Util {
    public static function emailBlast($attr) {
        global $database;
        foreach($database->select('members', '*') as $i) {
            mail($i['email'], $attr['subject'], $attr['message']);
        }
    }

    public static function formatPhoneNum($num) {
        return "(" . substr($num, 0, 3) . ") " . substr($num, 3, 3) . "-" . substr($num, 6, 4);
    }

    public static function getCalEvents() {
        global $database;
        $events = array();
        foreach($database->select('events', '*') as $i) {
            $events[] = array(
                'id' => $i['id'],
                'title' => $i['name'],
                'class' => 'event-important',
                'start' => (strtotime($i['date']) . '000' + 86400000)
            );
        }
        foreach($database->select('meetings', '*') as $i) {
            $events[] = array(
                'id' => $i['id'],
                'title' => $i['description'],
                'class' => 'event-info',
                'start' => (strtotime($i['date']) . '000' + 86400000)
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

    public static function signIn($bvid) {
        global $database;

        if($database->has('members', ['bvid' => $bvid])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['bvid'] = $bvid;
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    public static function addEvent($attr) {
        global $database;
        $database->insert('events', [
            'name' => $attr['name'],
            'hours' => $attr['hours'],
            'date' => $attr['date'],
            'maxmembers' => $attr['maxmembers']
        ]);
    }

    public static function removeEvent($id) {
        global $database;
        $members = json_decode($database->get('events', 'members', ['id' => $id]));
        foreach($members as $bvid) {
            $updated_events = array_diff(json_decode($database->get('members', 'events', ['bvid' => $bvid])), array($id));
            $database->update('members', ['events' => json_encode($updated_events)], ['bvid' => $bvid]);
        }
        $database->delete('events', ['id' => $id]);
    }

    public static function addMeeting($attr) {
        global $database;
        $database->insert('meetings', [
            'description' => $attr['description'],
            'date' => $attr['date']
        ]);
    }

    public static function removeMeeting($id) {
        global $database;
        $database->delete('meetings', ['id' => $id]);
    }

    public static function joinEvent($id) {
        global $database;
        $events = json_decode(Util::getCUser()['events']);
        if(!in_array($id, $events)) { //Only if not already subscribed
            $members = json_decode($database->get('events', 'members', ['id' => $id]));
            if(count($members) < $database->get('events', 'maxmembers', ['id' => $id])) {
                $members[] = Util::getCUser()['id'];
                $events[] = $id;
                $database->update('members', ['events' => json_encode($events)], ['bvid' => $_SESSION['bvid']]);
                $database->update('events', ['members' => json_encode($members)], ['id' => $id]);
            }
        }
    }

    public static function leaveEvent($id) {
        global $database;
        $events = json_decode(Util::getCUser()['events']);
        if(in_array($id, $events)) { //Only if already subscribed
            $members = json_decode($database->get('events', 'members', ['id' => $id]));
            unset($members[array_search(Util::getCUser()['id'], $members)]);
            $members = array_values($members);
            unset($events[array_search($id, $events)]);
            $events = array_values($events);
            $database->update('members', ['events' => json_encode($events)], ['bvid' => $_SESSION['bvid']]);
            $database->update('events', ['members' => json_encode($members)], ['id' => $id]);
        }
    }

    public static function inEvent($id) {
        global $database;
        $events = json_decode(Util::getCUser()['events']);
        if(in_array($id, $events)) {
            return true;
        }
        return false;
    }

    public static function isFull($id) {
        global $database;
        $event = $database->get('events', '*', ['id' => $id]);
        if(count(json_decode($event['members'])) == $event['maxmembers']) {
            return true;
        }
        return false;
    }

    public static function addUser($attr) {
        global $database;
        $database->insert('members', [
            'name' => $attr['name'],
            'email' => $attr['email'],
            'phone' => $attr['phone'],
            'hours' => $attr['hours'],
            'bvid' => $attr['bvid']
        ]);
    }

    public static function removeUser($id) {
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