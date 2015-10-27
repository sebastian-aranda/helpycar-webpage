/* Register Form */
function validateForm(){
	var name = $('#name').val();
    var email = $('#email').val();
    var email2 = $('#email2').val();
    var password = $('#password').val();

    var proceed = true;
    var error;    

    if (password == "" || password == null){
    	$('#password').focus();
        proceed = false;
        error = "Debe ingresar un password";
    }

    if (email != email2){
    	$('#email2').focus();
    	proceed = false;
    	error = "Los correos no coinciden";
    }

    if (email == "" || email == null){
    	$('#email').focus();
        proceed = false;
        error = "Debe ingresar un correo";
    }

    if (name == "" || name == null){
    	$('#name').focus();
        proceed = false;
        error = "Debe ingresar un nombre";
    }

    if (!proceed)
    	alert(error);

    return proceed;
}

/*
$("#register").on("click", (function() {
    //Obtener valores
    var name = $('#name').val();
    var email = $('input[id=email]').val();
    var email2 = $('input[id=email2]').val();
    var password = $('input[id=password]').val();

    var proceed = true;
    
    //Revisar campos en blanco
    if(name == ""){
        $('input[id=name]').css('border-color','red');
        proceed = false;
    }
    if(email==""){
        $('input[id=email]').css('border-color','red');
        proceed = false;
    }
    if(mensaje=="") {    
        $('input[id=password]').css('border-color','red');
        proceed = false;
    }
    
    //Revisar verificacion de email
    if (email != email2){
    	$('input[id=email2]').css('border-color','red');
    	proceed = false;
    }

    if(!proceed){
        //data to be sent to server
        post_data = {'name':nombre, 'email':email, 'password':password};
       
        //Ajax post data to server
        $.post('register_action.php', post_data, function(response){});
    }
}));


//reset previously set border colors and hide all message on .keyup()
$("#register_form input").keyup(function() {
    $("#register_form input").css('border-color','');
});
*/