<?php

function getSpecificEvent($eventid) {
    global $database;
    $event = $database->get('events', '*', ['id' => $eventid]);
    $page .= '
<div id="textbox" class="hidden">
        <textarea class="form-control" rows="15" id="description-box" name="description" placeholder="Write the description of the event here"></textarea>
        <button id="description-submit" class="btn btn-default form-control">Submit</button>
</div>
<div id="id" class="hidden">'.$event['id'].'</div>
<div class="container">
    <div class="page-header">
        <h2>' . $event['name'] . ' <small> ' . date("l, F j, Y", strtotime($event['date'])) . '</small></h2>
    </div>
    <div id="description-col" class="col-md-6">
        <p id="description" class="lead">'.$event['description'].'</p>
    </div>
    <div class="col-md-6">
        <div>
            <h2>Projected Hours: ' . $event['hours'] . '</h2>
        </div>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <p>Current attendees</p>
            </div>
            <ul class="list-group">';
    foreach (json_decode($event['members']) as $id) {
        $page .= '<li class="list-group-item">' . $database->get('members', 'name', ['id' => $id]) . '</li>';
    }
    $page .= '
            </ul>
        </div>
    </div>
    <script>
$("#description").on("click", function(e) {
    e.preventDefault();
    $(this).parent().html($("#textbox").html());
});
$("#description-col").on("click", "#description-submit", function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "/php/main.php",
        data: {
            util: "edit_event_description",
            attr: {
                id: $("#id").html(),
                description: $("#description-col > #description-box").val()
            }
        }
    }).done(function(data) {
        $("#main").html(data);
    });
});
    </script>
</div>';
    Page::write($page);
}
?>
