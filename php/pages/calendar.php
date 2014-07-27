<?php
function get_cal() {
    $page = '
<div id="calendar-div"></div>
<script type="text/javascript">
        var calendar = $("#calendar-div").calendar(
            {
                tmpl_path: "/tmpls/",
                events_source: function () { return []; }
            });
    </script>
';
    Page::Write($page);
}
?>