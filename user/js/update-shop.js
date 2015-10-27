$(function() {
    var id_rubros_selected = [];
    var id_rubros_selected_old = [];

    $("#rubros-selected-old span.rubro-selected input").each(function(){
        id_rubros_selected_old.push($(this).val());
    });

    $("#rubros-selected-old").on("click", ".rubro-selected",function(){
        id_rubros_selected_old.splice($(this).index(),1);
        id_rubro_deleted = $(this).children("input").val();
        $("#rubros-deleted").append("<input name='rubros-deleted[]' value='"+id_rubro_deleted+"'>");
        $(this).remove();
    });

    $("#rubros-selected").on("click", ".rubro-selected",function(){
        id_rubros_selected.splice($(this).index(),1);
        $(this).remove();
    });

    $("#agregar-rubro").on("click", function(){
        var id_rubro_selected = $("#rubro").val();
        if (id_rubro_selected == 0){
            alert("Debe seleccionar un rubro");
            return;
        }

        if (id_rubros_selected.indexOf(id_rubro_selected) != -1 || id_rubros_selected_old.indexOf(id_rubro_selected) != -1){
            alert("Ya agrego el rubro seleccionado");
            return;
        }

        id_rubros_selected.push(id_rubro_selected);

        var rubro_selected = $("#rubro option[value='"+$("#rubro").val()+"']").text();
        var qRubros_selected = $("#rubros-selected span.rubro-selected").length;
        var qRubros_selected_old = $("#rubros-selected-old span.rubro-selected").length;
        
        var premium = $("#premium").val();
        var rubrosPremium = [1,3,5,7,100];

        if (rubrosPremium[premium] > (qRubros_selected+qRubros_selected_old)){
            $("#rubros-selected").append("<span class='rubro-selected'>"+rubro_selected+"<input type='hidden' id='rubro-"+(qRubros_selected+1)+"' name='rubro-"+(qRubros_selected+1)+"' value='"+id_rubro_selected+"'></span>");
            $("#qRubros").val(qRubros_selected+1);
        }            
        else
            alert("Para poder agregar mas rubros cambie a una membresia premium mejor");
    });

    var _URL = window.URL || window.webkitURL;
    $("#logo").change(function(e) {
        var file, img;

        $("#logo_ok").val(1);
        if ((file = this.files[0])) {
            var file_dot_position = file.name.lastIndexOf(".");
            var file_ext = file.name.substring(file_dot_position, file.name.length).toLowerCase();
            if (file_ext != ".jpg" && file_ext != ".png" ){
                $("#logo_ok").val(0);
                $("#logo_error").val("Debe ingresar un formato de logo válido (jpg, png)");
            }

            img = new Image();
            img.onload = function() {
                if (this.width > 100 || this.height > 100){
                    $("#logo_ok").val(0);
                    $("#logo_error").val("El tamaño del logo no debe superar los 100x100px");
                    alert("El tamaño del logo no debe superar los 100x100px");
                }
                else{
                    $(".logo-section").html("");
                    $(this).addClass("logo");
                    $(this).appendTo(".logo-section");
                }
            };
            img.onerror = function() {
                $("#logo_ok").val(0);
                $("#logo_error").val("Error al cargar la imagen, intente nuevamente");
            };
            img.src = _URL.createObjectURL(file);
        }
    });

    $("#photo").change(function(e) {
        var file, img;

        $("#photo_ok").val(1);
        if ((file = this.files[0])) {
            var file_dot_position = file.name.lastIndexOf(".");
            var file_ext = file.name.substring(file_dot_position, file.name.length).toLowerCase();
            if (file_ext != ".jpg" && file_ext != ".png" ){
                $("#photo_ok").val(0);
                $("#photo_error").val("Debe ingresar un formato de foto válido (jpg, png)");
            }

            img = new Image();
            img.onload = function() {
                if (this.width > 300 || this.height > 200){
                    $("#photo_ok").val(0);
                    $("#photo_error").val("El tamaño de la foto no debe superar los 300x200px");
                    alert("El tamaño de la foto no debe superar los 300x200px");
                }
                else{
                    $(".photo-section").html("");
                    $(this).addClass("photo");
                    $(this).appendTo(".photo-section");
                }
            };
            img.onerror = function() {
                $("#photo_ok").val(0);
                $("#photo_error").val("Error al cargar la imagen, intente nuevamente");
            };
            img.src = _URL.createObjectURL(file);
        }
    });
});

/* Udate Form */
function validateForm(){
    var nombre = $('#nombre').val();
    var comuna = $('#comuna').val();
    var telefono1 = $('#telefono1').val();
    var telefono2 = $('#telefono2').val();
    var email = $('#email').val();
    var logo = $('#logo_ok').val();
    var photo = $('#photo_ok').val();
    var descripcion = $('#descripcion').val();
    
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
        error = "Debe ingresar una descripcion";
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