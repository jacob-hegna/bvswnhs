<?php

function getHome() {
    $page =
<<<EOD
<script>
    $('#hours-submit').on('click', function(e) {
        e.preventDefault();
        if(/[0-9]{8}/.test($('#bvid').val())) {
            $.ajax({
                type: 'post',
                url: '/php/main.php',
                data: {
                    util: "sign_in",
                    attr: {
                        bvid: $('#bvid').val()
                    }
                }
            }).done(function(data) {
                if(data == "success") {
                    $.ajax({
                        type: 'post',
                        url: '/php/main.php',
                        data: {
                            page: "profile"
                        }
                    }).done(function(data) {
                        $('#main').html(data);
                    });
                }
            });
        } else {
            alert('Invalid ID');
        }
    });
</script>
<a href="https://github.com/jacob-hegna/bvswnhs" target="_blank"><img style="position:absolute;top:0;right:0;" src="/img/github.png" alt="Fork me on GitHub"></a>
<div class="jumbotron">
    <center>
        <h2><img width="50px" src="/img/nhs.png"> BVSW NHS <small class="hidden-sm hidden-xs">Making the world a more honorable place</small></h2>
    </center>
</div>
<form>
    <div id="hour-form" class="input-group input-group-lg">
        <span class="input-group-addon hidden-xs">Student ID</span>
        <input id="bvid" class="form-control" type="password" autofocus>
        <span class="input-group-btn">
            <button id="hours-submit" class="btn btn-default" type="submit" type="button">Login <i class="fa fa-sign-in"></i></button>
        </span>
    </div>
</form>
EOD;
    echo $page;
}

?>
