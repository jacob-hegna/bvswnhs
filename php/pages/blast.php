<?php

function getBlast() {
    Page::write('
<script>
    $("#send").on("click", function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/php/main.php",
            data: {
                util: "email_blast",
                attr: {
                    subject: $("#subject").val(),
                    message: $("#message").val()
                }
            }
        }).done(function(data) {
            if(data == "success") {
                $.ajax({
                    type: "post",
                    url: "/php/main.php",
                    data: {
                        page: "home"
                    }
                }).done(function(data) {
                    $("#main").html(data);
                });
            }
        });
    });
</script>
<h1 style="text-align:center">Email Blast</h1>
<br>
<div class="input-group input-group">
    <input id="subject" class="form-control" placeholder="Subject" autofocus>
    <span class="input-group-btn">
        <button id="send" class="btn btn-default" type="submit" type="button">Send <i class="fa fa-mail-forward"></i></button>
    </span>
</div>
<textarea class="form-control" rows="5" id="message" name="message" placeholder="Message"></textarea>
    ');
}

?>