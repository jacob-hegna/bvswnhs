<?php
function get_events() {
    Page::write('
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
    <thead>
        <th>Event</th>
        <th>Possible hours</th>
        <th>Date</th>
    </thread>
    <tbody>
    </tbody>
</table>
    ');
}
?>