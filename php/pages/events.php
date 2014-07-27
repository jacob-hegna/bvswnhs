<?php
function get_events() {
    global $database;
    $page = '
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
    <thead>
        <th>Event</th>
        <th>Possible hours</th>
        <th>Date</th>
    </thread>
    <tbody>';

    foreach($database->select('events', '*') as $i) {
        $page .= '
        <tr>
            <td>' . $i['name']  . '</td>
            <td>' . $i['hours']  . '</td>
            <td>' . $i['date'] . '</td>
            ' . ((Util::getUser($_SESSION['bvid'])['rank'] >= 1) ? '<td><button id="'.$i['id'].'" class="remove-event btn btn-danger btn-sm">Remove</button></td>' : '') . '
        </tr>';
    }
    if(Util::getUser($_SESSION['bvid'])['rank'] >= 1) {
        $page .= '
        <tr>
            <td><input id="name-box" class="form-control" placeholder="Name" required="" autofocus></td>
            <td><input id="hour-box" class="form-control" placeholder="Possible Hour(s)" required=""></td>
            <td><input id="date-box" class="form-control" placeholder="Date" required=""></td>
            <td><button id="add-event" class="btn btn-primary btn-sm">Submit</button></td>
        </tr>
        <script>
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
        </script>';
    }
    $page .= '
    </tbody>
</table>';
    Page::write($page);
}
?>