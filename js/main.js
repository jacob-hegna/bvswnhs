$(document).ready(function() {
    var url  = $.url();
    var p    = url.segment(1);

    if(p == '') {
        history.pushState({}, "", "/home/");
        p = "home";
    }

    $.ajax({
        type: 'post',
        url: '/php/main.php',
        data: {
                page: p
        }
    }).done(function(data) {
        if(data != 'refresh') {
            $('#main').html(data);
            if(p == 'home') {
                $('#home').parent().addClass('active');
            }
        } else {

        }
    });

});

function loadTab(t) {
    $("#loadbar").loadie(.1);
    $(".loadie").fadeIn();
    $.ajax({
        type: "post",
        url: "/php/main.php",
        data: {
            page: t
        }
    }).done(function(data) {
        history.pushState({}, "", "/" + t + "/");
        $("#main").html(data);
        $("#" + t).parent().addClass("active");
        setTimeout(function() {
            $("#loadbar").loadie(1);
        }, 100);
    });
}