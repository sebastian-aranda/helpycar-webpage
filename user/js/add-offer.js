$(function() {
    $(".btn-add-offer").on("click",function(){
        var reference = parseInt($(this).siblings(".reference").val());
        var num_offer = parseInt($(this).siblings(".num-offer").text());
        var new_offer = $(".new-offer").eq(reference);

        if (num_offer > 0 )
            new_offer.toggle();
        else
            alert("Mejore su cuenta a premium");
    });

    $(".btn-save-offer").on("click", function(){
        var id_local = parseInt($(this).siblings(".id_local").val());
        var producto = $(this).parent().siblings().eq(0).children().val();
        var precio = $(this).parent().siblings().eq(1).children().val();

        var data = {
            "ofertas"   : 1,
            "producto"  : producto,
            "precio"    : precio,
            "id_local"  : id_local
        };

        $.post('../../setData.php', data, function(response){
            alert(response.message);
            window.location.href = "../pages/add-offer.php";
        }, 'json');
    });
});

/* Register Form */
function validateForm(){
	var nombre = $('#nombre').val();
    var calle = $('#address-street').val();
    var numero= $('#address-number').val();
    var comuna = $('#comuna').val();
    var telefono1 = $('#telefono1').val();
    var telefono2 = $('#telefono2').val();
    var email = $('#email').val();
    var logo = $('#logo_ok').val();
    var photo = $('#photo_ok').val();
    var descripcion = $('#descripcion').val();
    
    //Date Validation 
    var days = [];
    var times = [];

    var proceed_days = false;
    if ($('#monday').prop('checked') || $('#tuesday').prop('checked') || $('#wednesday').prop('checked') || $('#thursday').prop('checked') || $('#friday').prop('checked') || $('#saturday').prop('checked') || $('#sunday').prop('checked'))
        proceed_days = true;

    var proceed_time = false;
    times[0] = $('#time-start').val();
    times[1] = $('#time-end').val();
    if (times[0] != String(-1) && times[1] != String(-1))
        proceed_time = true;

    var proceed = true;
    var error;

    if (descripcion == "" || descripcion == null){
        $('#descripcion').focus();
        proceed = false;
        error = "Debe ingresar una descripción";
    }

    if (photo == 0){
        $("#photo").focus();
        error = $("#photo_error").val();
        proceed = false;
    }

    if (logo == 0){
        $("#logo").focus();
        error = $("#logo_error").val();
        proceed = false;
    }

    if (!proceed_time){
        $('#time-start').focus();
        proceed = false;
        error = "Debe ingresar un horario de trabajo válido";
    }

    if (!proceed_days){
        $('#monday').focus();
        proceed = false;
        error = "Debe ingresar a lo menos un día de trabajo";
    }

    if (email == "" || email == null){
        $('#email').focus();
        proceed = false;
        error = "Debe ingresar un email";
    }

    if (telefono1 == "" || telefono1 == null || telefono2 == "" || telefono2 == null){
        $('#telefono1').focus();
        proceed = false;
        error = "Debe ingresar un teléfono";
    }

    if (isNaN(telefono1) || isNaN(telefono2) || telefono2.length < 8){
        $('#telefono1').focus();
        proceed = false;
        error = "Debe ingresar un teléfono válido"
    }

    if (comuna == "" || comuna == null || comuna == 0){
        $('#comuna').focus();
        proceed = false;
        error = "Debe ingresar una comuna";
    }

    if (numero == "" || numero == null){
        $('#address-number').focus();
        proceed = false;
        error = "Debe ingresar un número de calle";
    }

    if (calle == "" || calle == null){
        $('#address-street').focus();
        proceed = false;
        error = "Debe ingresar una calle";
    }

    if (rubro == "" || rubro == null || rubro == 0){
        $('#rubro').focus();
        proceed = false;
        error = "Debe ingresar un rubro";
    }

    if (nombre == "" || nombre == null){
    	$('#nombre').focus();
        proceed = false;
        error = "Debe ingresar un nombre";
    }

    if (!proceed)
    	alert(error);

    return proceed;
}


function contadorCaracteres(num_caracter){
    var mensaje = $('#descripcion').val();
    var restantes = num_caracter - mensaje.length;
    $('#num_caracter').text(restantes);
}