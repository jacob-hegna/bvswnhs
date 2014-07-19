<?php

function get_home() {
    $page =
<<<EOD
<script>
    $('#hours-submit').on('click', function(e) {
        e.preventDefault();
        if(/[0-9]{8}/.test($('#bvid').val())) {
            $.ajax({
                type: 'post',
                url: 'php/main.php',
                data: {
                    bvid: $('#bvid').val()
                }
            }).done(function(data) {
                alert(data);
            });
        } else {
            alert('Invalid ID');
        }
    });
</script>
<div class="jumbotron">
    <h2><img width="50px" src="img/nhs.png"> BVSW NHS <small>Making the world a more honorable place</small></h2>
</div>
<div id="hour-form" class="input-group input-group-lg">
    <span class="input-group-addon">Student ID</span>
    <input id="bvid" class="form-control" autofocus>
    <span class="input-group-btn">
        <button id="hours-submit" class="btn btn-default" type="button">Check</button>
    </span>
</div>
EOD;
    echo $page;
}

?>