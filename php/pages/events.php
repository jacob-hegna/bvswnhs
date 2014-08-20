<?php
function getEvents() {
    global $database;
    $page = '
<script>

function loadEventTab(name) {
    $("tbody > tr:not(#new-event-row)").each(function() {
        var eleid = $(this).find("td").find("button").attr("id");
        var elename = $("#name", this).text().trim().toLowerCase();
        elename = elename.replace(/ /g, "-");
        if(name == elename) {
            $.ajax({
                type: "post",
                url: "/php/main.php",
                data: {
                    page: "events",
                    attr: {
                        id: eleid
                    }
                }
            }).done(function(data) {
                $("#main").html(data);
            });
        }
    });
}
if($.url().segment(2) != undefined) {
    loadEventTab($.url().segment(2).toLowerCase());
}

initMemberCtrls = function() {
    var events = ' . Util::getCUser()['events'] . ';
    $(".act-on-event").each(function() {
        $(this).text($.inArray($(this).attr("id"), events) < 0 ? "Join" : "Leave");
    });
    $("#new-event-row").hide();
    $(".act-on-event").unbind();
    $(".act-on-event").each(function() {
        $(this).on("click", function(e) {
            e.preventDefault();
            eleid = $(this).attr("id");
            $.ajax({
                type: "post",
                url: "/php/main.php",
                data: {
                    util: $.inArray(eleid, events) < 0 ? "join_event" : "leave_event",
                    attr: {
                        id: eleid,
                    }
                }
            }).done(function(data) {
                loadTab("events");
            });
        });
    });
}
initMemberCtrls();
</script>
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
<h1 style="text-align: center">Events</h1>
    <thead>
        <th width="23%">Name</th>
        <th width="23%">Hours</th>
        <th width="23%">Date</th>
        <th width="23%">Current Availability</th>' . (Util::getCUser()['rank'] >= 1 ?
        '<th><button id="admin" class="btn btn-primary btn-sm form-control">Admin <i class="fa fa-pencil-square"></i></button></th>':'') .
    '</thead>
    <tbody>';

    foreach($database->select('events', '*') as $i) {
        $page .= '
        <tr id="'.$i['id'].'">
            <td id="name" class="table-editable">' . $i['name'] . (Util::inEvent($i['id']) ? ' <span class="badge alert-success"><span class="fa fa-check"></span></span>' : '') . '</td>
            <td class="table-editable">' . $i['hours']  . '</td>
            <td class="table-editable">' . $i['date'] . '</td>
            <td class="table-editable">' . (Util::isFull($i['id']) ? 'Full' : count(json_decode($i['members'])) . ' / ' . $i['maxmembers']) . '</td>
            <td><button id="'.$i['id'].'" class="act-on-event btn btn-danger btn-sm form-control">Join</button></td>
        </tr>';
    }
    if(Util::getCUser()['rank'] >= 1) {
        $page .= '
        <tr id="new-event-row">
            <td><input id="name-box" class="form-control" placeholder="Name" required="" autofocus></td>
            <td><input id="hour-box" class="form-control" placeholder="Possible Hour(s)" required=""></td>
            <td><input id="date-box" class="form-control" placeholder="Date" required=""></td>
            <td><input id="maxmem-box" class="form-control" placeholder="Maximum Members" required=""></td>
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
                date: $("#date-box").val(),
                maxmembers: $("#maxmem-box").val()
            }
        }
    }).done(function(data) {
        loadTab("events");
    });
});
$("tbody > tr:not(#new-event-row)").each(function() {
    $(this).on("click", function(e) {
        e.preventDefault();
        var eleid = $(this).find("td").find("button").attr("id");
        var name = $("#name", this).text().trim().toLowerCase();
        name = name.replace(/ /g, "-");
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                page: "events",
                attr: {
                    id: eleid
                }
            }
        }).done(function(data) {
            $("#main").html(data);
            history.pushState({}, "", "/events/" + name + "/");
        });
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
