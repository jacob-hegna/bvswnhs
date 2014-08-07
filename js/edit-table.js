$(".table-editable").on("click", function(e) {
    if($(this).hasClass("editing") == false) {
        $(this).addClass("editing");
        $(this).html($("#editable-template").html());
    }
});
$(document).delegate("#editable-submit", "click", function() {
    var url  = $.url();
    $.ajax({
        type: "post",
        url: "/php/main.php",
        data: {
            util: "edit_sql",
            attr: {
                table: url.segment(1),
                id: $(this).closest("td").attr("id"),
                column: $(this).closest("table").find("th").eq($(this).closest("td").index()).html().toLowerCase(),
                new: $(this).closest("span").prev().val()
            }
        }
    }).done(function(data) {
        loadTab(url.segment(1));
    });
});