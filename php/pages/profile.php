<?php
function getProfile() {
    global $database;
    $myevents = json_decode($database->get('members', 'events', ['bvid' => $_SESSION['bvid']]));
    $events = array_map(function($eventid) {
        global $database;
        return $database->get('events', '*', ['id' => $eventid]);
    }, $myevents);
    $page = '
<div class="container">
    <h1 style="text-align: center">' . Util::getCUser()['hours'] . ' Hours Logged</h1><br />
    <div>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#current" data-toggle="tab">Current Events</a></li>
            <li><a href="#past" data-toggle="tab">Past Events</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="current">
                <table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Hours</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
';
    foreach (array_filter($events, function($event) {
        return strtotime($event['date']) >= strtotime(date("Y-m-d"));
    }) as $i) {
        $page .= '
                <tr>
                    <td>'.$i['name'] .'</td>
                    <td>'.$i['hours'].'</td>
                    <td>'.$i['date'] .'</td>
                </tr>
';
    }
    $page .= '
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="past">
                <table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Hours</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
';
    foreach (array_filter($events, function($event) {
        return strtotime($event['date']) < strtotime(date("Y-m-d"));
    }) as $i) {
        $page .= '
                <tr>
                    <td>'.$i['name'] .'</td>
                    <td>'.$i['hours'].'</td>
                    <td>'.$i['date'] .'</td>
                </tr>
';
    }
    $page .= '
            </div>
        </div>
    </div>
</div>
';
    Page::write($page);
}
?>