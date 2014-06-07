$(document).ready(function() {
    $('#hours-submit').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'php/main.php',
            data: {
                bvid: $('#bvid').val()
            }
        }).done(function(data) {
            alert(data);
        });
    });
});