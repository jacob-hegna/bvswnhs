<?php
function get_profile() {
    global $database;
    $page = '
<div class="container">
    <h1 style="text-align: center">' . Util::getUser($_SESSION['bvid'])['hours'] . ' Hours Logged</h1><br />
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#">Current Events</a></li>
            <li><a href="#">Past Events</a></li>
        </ul>
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
    # Some fancy code here to do database queries
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
    # End fancy code
    $page .= '
            </tbody>
        </table>
    </div>
</div>
';
    Page::write($page);
}
?>