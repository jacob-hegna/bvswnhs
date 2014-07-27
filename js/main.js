$(document).ready(function() {
    var url  = $.url();
    var p    = url.segment(1);

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