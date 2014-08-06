<?php
function getMeetings() {
    global $database;
    $page = '
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
<h1 style="text-align: center">Meetings</h1>
    <thead>
        <th>Description</th>
        <th>Date</th>
    </thead>
    <tbody>';

    foreach($database->select('meetings', '*') as $i) {
        $page .= '
        <tr>
            <td>' . $i['description'] . '</td>
            <td>' . $i['date']  . '</td>' . (Util::getCUser()['rank'] >= 1 ?
                '<td><button id="'.$i['id'].'" class="btn btn-danger btn-sm form-control remove-meeting">Remove</button></td>' : ''
            ) . '
        </tr>';
    }
    if(Util::getCUser()['rank'] >= 1) {
        $page .= '
        <tr id="new-meeting-row">
            <td><input id="description-box" class="form-control" placeholder="Description" required="" autofocus></td>
            <td><input id="date-box" class="form-control" placeholder="Date" required=""></td>
            <td><button id="add-meeting" class="btn btn-primary btn-sm form-control">Submit</button></td>
        </tr>
        <script>
$("#add-meeting").on("click", function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "/php/main.php",
        data: {
            util: "add_meeting",
            attr: {
                description: $("#description-box").val(),
                date: $("#date-box").val(),
            }
        }
    }).done(function(data) {
        loadTab("meetings");
    });
});
$(".remove-meeting").on("click", function(e) {
    e.preventDefault();
    var eleid = $(this).attr("id");
    $.ajax({
        type: "post",
        url: "/php/main.php",
        data: {
            util: "remove_meeting",
            attr: {
                id: eleid
            }
        }
    }).done(function(data) {
        loadTab("meetings");
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
