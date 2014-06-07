$(document).ready(function() {
    $('#hours-submit').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'php/main.php',
            data: {
                bvid: $(this).data
            }
        }).done(function(data) {
            alert(data);
        });
    });
});