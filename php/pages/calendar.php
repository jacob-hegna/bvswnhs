<?php
function get_cal() {
    $page = '
<h1 style="text-align: center">Calendar</h1>
<br>
<div id="calendar-div"></div>
<script type="text/javascript">
    var calendar = $("#calendar-div").calendar(
        {
            tmpl_path: "/tmpls/",
            events_source: "/php/get_events.php"
        });
</script>
';
    Page::Write($page);
}
?>