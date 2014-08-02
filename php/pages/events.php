<?php
function getEvents() {
    global $database;
    $page = '
<script>
initMemberCtrls = function() {
    $(".act-on-event").text("Join");
    $("#new-event-row").hide();
    $(".act-on-event").unbind();
    $(".act-on-event").on("click", function(e) {
        e.preventDefault();
        eleid = $(this).attr("id");
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                util: "join_event",
                attr: {
                    id: eleid,
                }
            }
        }).done(function(data) {
            loadTab("events");
        });
    });
}
initMemberCtrls();
</script>
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
<h1 style="text-align: center">Events</h1>
    <thead>
        <th>Event</th>
        <th>Possible hours</th>
        <th>Date</th>' . (Util::getCUser()['rank'] >= 1 ?
        '<th><button id="admin" class="btn btn-primary btn-sm form-control">Admin <i class="fa fa-pencil-square"></i></button></th>':'') .
    '</thead>
    <tbody>';

    foreach($database->select('events', '*') as $i) {
        $page .= '
        <tr>
            <td>' . $i['name'] . '</td>
            <td>' . $i['hours']  . '</td>
            <td>' . $i['date'] . '</td>
            <td><button id="'.$i['id'].'" class="act-on-event btn btn-danger btn-sm form-control">Join</button></td>
        </tr>';
    }
    if(Util::getCUser()['rank'] >= 1) {
        $page .= '
        <tr id="new-event-row">
            <td><input id="name-box" class="form-control" placeholder="Name" required="" autofocus></td>
            <td><input id="hour-box" class="form-control" placeholder="Possible Hour(s)" required=""></td>
            <td><input id="date-box" class="form-control" placeholder="Date" required=""></td>
            <td><button id="add-event" class="btn btn-primary btn-sm form-control">Submit</button></td>
        </tr>
        <script>
initAdminCtrls = function() {
    $(".act-on-event").text("Remove");
    $("#new-event-row").show();
    $(".act-on-event").unbind();
    $(".act-on-event").on("click", function(e) {
        e.preventDefault();
        eleid = $(this).attr("id");
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                util: "remove_event",
                attr: {
                    id: eleid
                }
            }
        }).done(function(d) {
            loadTab("events");
        });
    });
};
var mode = "member";
$("#admin").on("click", function(e) {
    if(mode == "member") {
        initAdminCtrls();
        mode = "admin";
    } else {
        initMemberCtrls();
        mode = "member";
    }
});
$("#add-event").on("click", function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "/php/main.php",
        data: {
            util: "add_event",
            attr: {
                name: $("#name-box").val(),
                hours: $("#hour-box").val(),
                date: $("#date-box").val()
            }
        }
    }).done(function(data) {
        loadTab("events");
    });
});
        </script>';
    }
    $page .= '
    </tbody>
</table>';
    Page::write($page);
}
?>
