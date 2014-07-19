<?php

function get_profile() {
    $name = Util::getUser($_SESSION['bvid'])['name'];
    $page =
<<<EOD
<script>
    $('#profile').on('click', function(e) {
        $.ajax({
            type: 'post',
            url: 'php/main.php',
            data: {
                page: "profile"
            }
        }).done(function(data) {
            $('#main').html(data);
        });
    });
    $('#sign_out').on('click', function(e) {
        $.ajax({
            type: 'post',
            url: 'php/main.php',
            data: {
                util: "sign_out"
            }
        }).done(function(data) {
            $.ajax({
                type: 'post',
                url: 'php/main.php',
                data: {
                    page: "home"
                }
            }).done(function(data) {
                $('#main').html(data);
            });
        });
    })
</script>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">$name</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#" id="profile">Profile</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="#" id="sign_out">Logout</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>
EOD;
    echo $page;
}

?>