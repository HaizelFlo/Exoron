
$( document ).ready(function() {
    $(".plus").click(function(){
        $(this).parent().parent().toggleClass("off")
        $(this).parent().parent().find(".plus span").toggle()

    });
});