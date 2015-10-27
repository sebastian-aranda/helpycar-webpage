<?php
if($_POST)
{
    $to_Email       = "aranda.sebastian@gmail.com"; //Replace with recipient email address
    $subject        = '[Contacto-HelpyCar]'; //Subject line for emails
   
    //check $_POST vars are set, exit if any missing
    if(!isset($_POST["nombre"]) || !isset($_POST["email"]) || !isset($_POST["mensaje"])){
        $output = array('type'=>'error', 'text' => 'Los datos están incompletos.');
    }

    //Sanitize input data using PHP filter_var().
    $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $mensaje = filter_var($_POST["mensaje"], FILTER_SANITIZE_STRING);
   
    //proceed with PHP email.

    /*
    Incase your host only allows emails from local domain,
    you should un-comment the first line below, and remove the second header line.
    Of-course you need to enter your own email address here, which exists in your cp.
    */
    //$headers = 'From: your-name@YOUR-DOMAIN.COM' . "\r\n" .
    $headers = 'From: '.$email.'' . "\r\n" . //remove this line if line above this is un-commented
    'Reply-To: '.$email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
   
        // send mail
    $sentMail = @mail($to_Email, $subject, $mensaje."\r\n\r\nAtte\r\n".$nombre, $headers);
   
    if (!$sentMail){
        $output = array('type'=>'message', 'text' => 'El mail no pudo ser enviado.');
    }
    else{
        $output = array('type'=>'message', 'text' => 'Gracias por enviar tu mensaje. Te responderemos a la brevedad.');
    }

    echo "<script>alert('".utf8_encode($output["text"])."');window.location.href = 'index.html';</script>";
}