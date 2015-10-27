/* Register Form */
function validateForm(){
	var nombre = $('#nombre').val();
    var email = $('#email').val();
    var mensaje = $('#mensaje').val();

    var proceed = true;
    var error;    

    if (mensaje == "" || mensaje == null){
    	$('#mensaje').focus();
        proceed = false;
        error = "Debe ingresar un mensaje";
    }

    if (email == "" || email == null){
    	$('#email').focus();
        proceed = false;
        error = "Debe ingresar un correo";
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