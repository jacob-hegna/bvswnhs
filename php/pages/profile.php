<?php
function get_profile() {
    global $database;
    $page = '
<div class="container">
    <h1 style="text-align: center">' . Util::getUser($_SESSION['bvid'])['hours'] . ' Hours Logged</h1>
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#">Current Events</a></li>
            <li><a href="#">Past Events</a></li>
        </ul>
        <table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
';
    # Some fancy code here to do database queries
    $page .= '
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Hours</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Do website shit</td>
                    <td>69</td>
                    <td>2014-07-26</td>
                </tr>
                <tr>
                    <td>Do more website shit</td>
                    <td>13</td>
                    <td>2014-07-27</td>
                </tr>
            </tbody>';
    # End fancy code
    $page .= '
        </table>
    </div>
</div>
';
Page::write($page);
}
?>