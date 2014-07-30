<?php
function get_members() {
    global $database;
    $page = '
<h1 style="text-align: center">Members</h1>
<table class="table table-hover" style="margin-top: 50px; text-align: left; font-size: medium;">
    <thead>
        <th>Name</th>
        <th>BV ID</th>
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
            <td>' . $i['name'] . ' <span class="label label-'.$rankColor.'">'.Util::getRank(Util::getUser($i['bvid'])['rank']).'</span></td>
            <td style="vertical-align:middle;">' . $i['bvid']  . '</td>
            <td style="vertical-align:middle;">' . $i['hours'] . '</td>
            <td style="vertical-align:middle;"><button id="'.$i['bvid'].'" class="remove-user btn btn-danger btn-sm form-control">Remove</button></td>
        </tr>';
    }

    $page .= '
        <tr>
            <td><input id="name-box" class="form-control" placeholder="Name" required="" autofocus></td>
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
                            bvid: $("#bvid-box").val(),
                            hours: $("#hour-box").val()
                        }
                    }
                }).done(function(data) {
                    $.ajax({
                        type: "post",
                        url: "/php/main.php",
                        data: {
                            page: "members"
                        }
                    }).done(function(data) {
                        $("#main").html(data);
                    });
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
                    $.ajax({
                        type: "post",
                        url: "/php/main.php",
                        data: {
                            page: "members"
                        }
                    }).done(function(data) {
                        $("#main").html(data);
                    });
                });
            });
        </script>
    </tbody>
</table>';
    Page::write($page);
}
?>