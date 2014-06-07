<?php
class Util {
    public static function getUser($id) {
        global $database;
        return $database->get('members', '*', ['bvid' => $id]);
    }
}
?>