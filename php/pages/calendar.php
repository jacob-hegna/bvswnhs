<?php
function get_cal() {
    $page = '
<h1 style="text-align: center">Calendar</h1>
<br>
<div id="calendar-div"></div>
<script type="text/javascript">
    var obj;
    $.ajax({
        type: "post",
        url: "/php/main.php",
        data: {
            util: "cal_events"
        }
    }).done(function(data) {
        obj = JSON.parse(data);
        var calendar = $("#calendar-div").calendar({
            tmpl_path: "/tmpls/calendar/",
            events_source: function() {
                return obj;
            }
        });
    });
</script>
';
    Page::Write($page);
}
?>