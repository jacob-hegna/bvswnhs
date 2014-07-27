<?php
class Util {
    public static function getUser($id) {
        global $database;
        return $database->get('members', '*', ['bvid' => $id]);
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
        $database->delete('events', ['id' => $id]);
    }

    public static function add_user($attr) {
        global $database;
        $database->insert('members', [
            'name' => $attr['name'],
            'hours' => $attr['hours'],
            'bvid' => $attr['bvid']
        ]);
    }

    public static function remove_user($id) {
        global $database;
        $database->delete('members', ['bvid' => $id]);
    }
}
?>