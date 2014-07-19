$(document).ready(function() {

    if($.ajax({
        type: 'post',
        url: 'php/main.php',
        data: {
            util: 'logged_in'
        },
        async: false
    }).responseText == '1') {}

    $.ajax({
        type: 'post',
        url: 'php/main.php',
        data: {
                page: 'home'
        }
    }).done(function(data) {
        if(data != 'refresh') {
            $('#main').html(data);
            console.log(data);
        } else {
            window.location('.');
        }
    });

});