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
        } else {

        }
    });

});