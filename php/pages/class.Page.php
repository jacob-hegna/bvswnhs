<?php
class Page {
    public function __construct() {

    }

    private function start() {
        echo '
<script>
    $("#loadbar").loadie();
    var tabs = [
        {"id": "home", "title": "Home"},
        {"id": "events", "title": "Events"},
        {"id": "members", "title": "Members"},
        {"id": "calendar", "title": "Calendar"},
        {"id": "blast", "title": "Email Blast"}
    ];
    $("#navbar-left").html(_.template($("#left-nav-template").html(), tabs));

    $(".tab").on("click", function(e) {
        e.preventDefault();
        loadTab($(this).attr("id"));
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
      <script id="left-nav-template" type="text/x-template">
          <% _.each(tabs, function(tab) { %>
              <li><a href="#" id="<%= tab.id %>" class="tab"><%= tab.title %></a></li>
          <% }); %>
      </script>
      <ul id="navbar-left" class="nav navbar-nav"></ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" id="sign_out">Logout <i class="fa fa-sign-out"></i> - ' . Util::getCUser()['name'] . '</a></li>
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