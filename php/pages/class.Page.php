<?php
class Page {
    public function __construct() {

    }

    private function start() {
        echo '
<script>
    $("#loadbar").loadie();
    $("#home").on("click", function(e) {
        e.preventDefault();
        $("#loadbar").loadie(.1);
        $(".loadie").fadeIn();
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                page: "home"
            }
        }).done(function(data) {
            history.pushState({}, "", "/home/");
            $("#main").html(data);
            $("#home").parent().addClass("active");
            setTimeout(function() {
                $("#loadbar").loadie(1);
            }, 100)
        });
    });
    $("#events").on("click", function(e) {
        e.preventDefault();
        $("#loadbar").loadie(.1);
        $(".loadie").fadeIn();
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                page: "events"
            }
        }).done(function(data) {
            history.pushState({}, "", "/events/");
            $("#main").html(data);
            $("#events").parent().addClass("active");
            setTimeout(function() {
                $("#loadbar").loadie(1);
            }, 100)
        });
    });
    $("#members").on("click", function(e) {
        e.preventDefault();
        $("#loadbar").loadie(.1);
        $(".loadie").fadeIn();
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                page: "members"
            }
        }).done(function(data) {
            history.pushState({}, "", "/members/");
            $("#main").html(data);
            $("#members").parent().addClass("active");
            setTimeout(function() {
                $("#loadbar").loadie(1);
            }, 100)
        });
    });
    $("#blast").on("click", function(e) {
        e.preventDefault();
        $("#loadbar").loadie(.1);
        $(".loadie").fadeIn();
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                page: "blast"
            }
        }).done(function(data) {
            history.pushState({}, "", "/blast/");
            $("#main").html(data);
            $("#blast").parent().addClass("active");
            setTimeout(function() {
                $("#loadbar").loadie(1);
            }, 100)
        });
    });
    $("#calendar").on("click", function(e) {
        e.preventDefault();
        $("#loadbar").loadie(.1);
        $(".loadie").fadeIn();
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                page: "calendar"
            }
        }).done(function(data) {
            history.pushState({}, "", "/calendar/");
            $("#main").html(data);
            $("#calendar").parent().addClass("active");
            setTimeout(function() {
                $("#loadbar").loadie(1);
            }, 200)
        });
    });
    $("#sign_out").on("click", function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                util: "sign_out"
            }
        }).done(function(data) {
            $.ajax({
                type: "post",
                url: "/php/main.php",
                data: {
                    page: "home"
                }
            }).done(function(data) {
                $("#main").html(data);
                history.pushState({}, "", "/home/");
            });
        });
    });
</script>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div style="z-index:99;" id="loadbar"></div>
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a id="logo" class="navbar-brand animated fadeInLeft">BVSW NHS <img width="20px" src="/img/nhs-white.png"></a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="#" id="home">Home</a></li>
        <li><a href="#" id="events">Events</a></li>
        <li><a href="#" id="calendar">Calendar</a></li>
        ' . ((Util::getUser($_SESSION['bvid'])['rank'] == 2) ?
        '<li><a href="#" id="members">Members</a></li>
        <li><a href="#" id="blast">Email Blast</a></li>' : '') . '
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" id="sign_out">Logout <i class="fa fa-sign-out"></i> - ' . Util::getUser($_SESSION['bvid'])['name'] . '</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>
<div class="jumbotron" style="margin-top: 75px">
';
    }

    static public function write($body) {
        Page::start();
        echo $body;
        Page::end();
    }

    private function end() {
        echo '
</div>
';
    }
};
?>