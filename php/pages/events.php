<?php
function get_events() {
    global $database;
    $page = '
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
<h1 style="text-align: center">Events</h1>
    <thead>
        <th>Event</th>
        <th>Possible hours</th>
        <th>Date</th>' . (Util::getUser($_SESSION['bvid'])['rank'] >= 1 ?
        '<th><button id="admin" class="btn btn-primary btn-sm form-control">Admin <i class="fa fa-pencil-square"></i></button></th>':'') .
    '</thead>
    <tbody>';

    foreach($database->select('events', '*') as $i) {
        $page .= '
        <tr>
            <td>' . $i['name']  . '</td>
            <td>' . $i['hours']  . '</td>
            <td>' . $i['date'] . '</td>
            ' . ((Util::getUser($_SESSION['bvid'])['rank'] >= 1) ? '<td><button id="'.$i['id'].'" class="remove-event btn btn-danger btn-sm form-control">Remove</button></td>' : '') . '
        </tr>';
    }
    if(Util::getUser($_SESSION['bvid'])['rank'] >= 1) {
        $page .= '
        <tr id="new-event-row">
            <td><input id="name-box" class="form-control" placeholder="Name" required="" autofocus></td>
            <td><input id="hour-box" class="form-control" placeholder="Possible Hour(s)" required=""></td>
            <td><input id="date-box" class="form-control" placeholder="Date" required=""></td>
            <td><button id="add-event" class="btn btn-primary btn-sm form-control">Submit</button></td>
        </tr>
        <script>
initAdminCtrls = function() {
    $(".join-event").addClass("remove-event");
    $(".join-event").removeClass("join-event");
    $(".remove-event").text("Remove");
    $("#new-event-row").show();
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
            $.ajax({
                type: "post",
                url: "/php/main.php",
                data: {
                    page: "events"
                }
            }).done(function(data) {
                $("#main").html(data);
            });
        });
    });
    $(".remove-event").on("click", function(e) {
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
            $.ajax({
                type: "post",
                url: "/php/main.php",
                data: {
                    page: "events"
                }
            }).done(function(data) {
                $("#main").html(data);
            });
        });
    });
};
initMemberCtrls = function() {
    $(".remove-event").addClass("join-event");
    $(".remove-event").removeClass("remove-event");
    $(".join-event").text("Join");
    $("#new-event-row").hide();
    $(".join-event").on("click", function(e) {
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
            $.ajax({
                type: "post",
                url: "/php/main.php",
                data: {
                    page: "events"
                }
            }).done(function(data) {
                $("#main").html(data);
            });
        });
    });
}
initMemberCtrls();
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
        </script>';
    }
    $page .= '
    </tbody>
</table>';
    Page::write($page);
}
?>
