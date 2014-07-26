<?php
function get_members() {
    global $database;
    $page = '
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
    <thead>
        <th>Name</th>
        <th>BV ID</th>
        <th>Hours</th>
    </thread>
    <tbody>';

    foreach($database->select('members', '*') as $i) {
        $page .= '
        <tr>
            <td>' . $i['name']  . '</td>
            <td>' . $i['bvid']  . '</td>
            <td>' . $i['hours'] . '</td>
        </tr>';
    }

    $page .= '
    </tbody>
</table>';
    Page::write($page);
}
?>