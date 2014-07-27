<?php
function get_profile() {
    global $database;
    $page = '
<div class="container">
    <h1 style="text-align: center">' . Util::getUser($_SESSION['bvid'])['hours'] . ' Hours Logged</h1><br />
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
    $myevents = json_decode($database->get('members', 'events', ['bvid' => $_SESSION['bvid']]));
    foreach ($myevents as $i) {
        $events = $database->get('events', '*', ['id' => $i]);
        $page .= '
                <tr>
                    <td>'.$events['name'] .'</td>
                    <td>'.$events['hours'].'</td>
                    <td>'.$events['date'] .'</td>
                </tr>
';
    }
    $page .= '
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="past">
                <p>Nothing has happened yet!</p>
            </div>
        </div>
    </div>
</div>
';
    Page::write($page);
}
?>