<?php
function getMembers() {
    global $database;
    $page = '
<div id="editable-template" style="display:none">
    <form class="input-group" style="width:auto">
        <input class="form-control" autofocus>
        <span class="input-group-btn">
            <button id="editable-submit" class="btn btn-default" type="submit" type="button">Submit</button>
        </span>
    </form>
</div>
<script src="/js/edit-table.js"></script>
<h1 style="text-align: center">Members</h1>
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>BVID</th>
        <th>Hours</th>
    </thread>
    <tbody>';

    foreach($database->select('members', '*') as $i) {
        $rankColor;
        switch($i['rank']) {
            case 0:
                $rankColor = 'success';
                break;
            case 1:
                $rankColor = 'primary';
                break;
            case 2:
                $rankColor = 'danger';
                break;
        }
        $page .= '
        <tr>
            <td id="'.$i['id'].'" class="table-editable">' . $i['name'] . ' <span class="label label-'.$rankColor.'">'.Util::getRank(Util::getUser($i['bvid'])['rank']).'</span></td>
            <td id="'.$i['id'].'" class="table-editable">' . $i['email']  . '</td>
            <td id="'.$i['id'].'" class="table-editable">' . Util::formatPhoneNum($i['phone']) . '</td>
            <td id="'.$i['id'].'" class="table-editable">' . $i['bvid'] . '</td>
            <td id="'.$i['id'].'" class="table-editable">' . $i['hours'] . '</td>
            <td><button id="'.$i['bvid'].'" class="remove-user btn btn-danger btn-sm form-control">Remove</button></td>
        </tr>';
    }

    $page .= '
        <tr>
            <td><input id="name-box" class="form-control" placeholder="Name" required="" autofocus></td>
            <td><input id="email-box" class="form-control" placeholder="Email" required=""></td>
            <td><input id="phone-box" class="form-control" placeholder="Phone Number" required=""></td>
            <td><input id="bvid-box" class="form-control" placeholder="BV ID" required=""></td>
            <td><input id="hour-box" class="form-control" placeholder="Hours" required=""></td>
            <td><button id="add-user" class="btn btn-primary btn-sm form-control">Submit</button></td>
        </tr>
        <script>
            $("#add-user").on("click", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/php/main.php",
                    data: {
                        util: "add_user",
                        attr: {
                            name: $("#name-box").val(),
                            email: $("#email-box").val(),
                            bvid: $("#bvid-box").val(),
                            phone: $("#phone-box").val(),
                            hours: $("#hour-box").val()
                        }
                    }
                }).done(function(data) {
                    loadTab("members");
                });
            });
            $(".remove-user").on("click", function(e) {
                e.preventDefault();
                memid = $(this).attr("id");
                $.ajax({
                    type: "post",
                    url: "/php/main.php",
                    data: {
                        util: "remove_user",
                        attr: {
                            id: memid
                        }
                    }
                }).done(function(d) {
                    loadTab("members");
                });
            });
        </script>
    </tbody>
</table>';
    Page::write($page);
}
?>
