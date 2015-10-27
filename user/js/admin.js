$(function() {
    $("#add-version").on("click", function(){
        var comentario = $("#comentario").val();

        var data = {
            "version"       : 1,
            "comentario"    : comentario
        };

        $.post('../../setData.php', data, function(response){
            alert(response.message);
            window.location.href = "../pages/versions.php";
        }, 'json');
    });
});