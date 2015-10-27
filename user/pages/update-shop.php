<?php
session_start();

if (!isset($_SESSION["loged"]))
  $html = file_get_contents("../session_error.html");
else{
  require_once("../../config.php");
  require_once("../../dist/class/class.connect.php");
  require_once("../../dist/functions/data.access.php");

  $c_host = $databaselocation;
  $c_user = $databaseuser;
  $c_pass = $databasepass;
  $c_db   = $databasename;

  $id_local = $_GET["local"];
  $local = getLocal($id_local);
  if ($local){
    $local = $local[0];
    $owner = $local->usuario; 
  }
  else
    $owner = 0;
  
  $userid = $_SESSION["userid"];

  if ($owner != $userid)
    $html = file_get_contents("local_error.html");
  else{
    $username = $_SESSION["username"];
    $premium = $_SESSION["premium"];

    $html = file_get_contents("update-shop.html");
    
    $html = str_replace("{USERNAME}", $username, $html);
    $html = str_replace("{PREMIUM}", $premium, $html);
    
    $html = str_replace("{ID}", $id_local, $html);

    $html = str_replace("{NOMBRE}", $local->nombre, $html);

    $rubros = getRubros();
    $html_rubros = "";
    foreach ($rubros as $rubro){
      $html_rubros .= "<option value='".$rubro->id."'>".$rubro->nombre."</option>";
    }
    $html = str_replace("{RUBROS}", $html_rubros, $html);

    $rubros_local = getRubrosLocal($id_local);
    $html_rubros_local = "";
    foreach ($rubros_local as $rubro_local)
      $html_rubros_local .= "<span class='rubro-selected'>".$rubro_local->nombre." <input value='".$rubro_local->id_rubro."' type='hidden'></span>";
    
    $html = str_replace("{RUBROS_SELECTED_OLD}", $html_rubros_local, $html);

    $comunas = getComunas();
    $html_comunas = "";
    foreach ($comunas as $comuna){
      $html_comunas .= "<option value='".$comuna->id."'>".$comuna->nombre."</option>";
    }
    $html = str_replace("{COMUNAS}", $html_comunas, $html);
    $html = str_replace("{COMUNA}", $local->comuna, $html);

    $html = str_replace("{DIRECCION}", $local->direccion, $html);

    $html_horarios = "";
    for ($i=0; $i<24; $i++)
      $html_horarios .= "<option value='".$i."'>".$i.":00</option>";
    
    $html = str_replace("{HORARIOS}", $html_horarios, $html);
    
    $telefono = $local->telefono;
    $telefono1 = substr($telefono, 3,1);
    $telefono2 = substr($telefono, 4,8);
    $html = str_replace("{TELEFONO1}", $telefono1, $html);
    $html = str_replace("{TELEFONO2}", $telefono2, $html);

    $html = str_replace("{EMAIL}", $local->mail, $html);
    
    $time_elements = explode(" ", $local->horario);
    $monday = "false";
    $tuesday = "false";
    $wednesday = "false";
    $thursday = "false";
    $friday = "false";
    $saturday = "false";
    foreach ($time_elements as $element){
      if ($element == "Lunes," || $element == "Lunes")
        $monday = "true";
      elseif ($element == "Martes," || $element == "Martes")
        $tuesday = "true";
      elseif ($element == "Miercoles," || $element == "Miercoles")
        $wednesday = "true";
      elseif ($element == "Jueves," || $element == "Jueves")
        $thursday = "true";
      elseif ($element == "Viernes," || $element == "Viernes")
        $friday = "true";
      elseif ($element == "Sabado")
        $saturday = "true";
    }
    $html = str_replace("{MONDAY}", $monday, $html);
    $html = str_replace("{TUESDAY}", $tuesday, $html);
    $html = str_replace("{WEDNESDAY}", $wednesday, $html);
    $html = str_replace("{THURSDAY}", $thursday, $html);
    $html = str_replace("{FRIDAY}", $friday, $html);
    $html = str_replace("{SATURDAY}", $saturday, $html);

    $times = explode("-", $time_elements[count($time_elements)-1]);
    $time1 = explode(":", $times[0]);
    $time2 = explode(":", $times[1]);
    $html = str_replace("{TIME1}", $time1[0], $html);
    $html = str_replace("{TIME2}", $time2[0], $html);


    $html = str_replace("{DESCRIPCION}", $local->descripcion, $html);
    $maxDescPremium = [150, 350, 500, 600, 600];
    $num_char = $maxDescPremium[$premium]-strlen($local->descripcion);
    $html = str_replace("{NUM_CARACTER}", $num_char, $html);

    //Mostrar Logo
    if ($local->logo != null)
      $html = str_replace("{SHOW_LOGO}", "<img class='logo' src='../../logos/".$local->logo."' alt='logo empresa'>", $html);
    else
      $html = str_replace("{SHOW_LOGO}", "<img class='logo' src='http://placehold.it/100' alt='no logo'>", $html);

    // Verificar permiso de agregar Logo
    if ($premium > 0)
      $html_logo = "<input name='logo' id='logo' type='file'>";
    else
      $html_logo = "<p style='color:red;'>Para poder editar el logo debe contar con membresía premium</p>";

    $html = str_replace("{LOGO_PERMISSION}", $html_logo, $html);

    //Mostrar Photo
    if ($local->photo != null)
      $html = str_replace("{SHOW_PHOTO}", "<img class='photo' src='../../photos/".$local->photo."' alt='foto empresa' class='photo'>", $html);
    else
      $html = str_replace("{SHOW_PHOTO}", "<img class='photo' src='http://placehold.it/300x200' class='photo'>", $html);

    // Verificar permiso de agregar foto
    if ($premium >= 2)
      $html_photo = "<input name='photo' id='photo' type='file'>";
    else if ($premium == 0)
      $html_photo = "<p style='color:red;'>Para poder editar la foto debe contar con una membresía premium</p>";
    else
      $html_photo = "<p style='color:red;'>Para poder editar la foto debe mejorar su membresía premium</p>";

    $html = str_replace("{PHOTO_PERMISSION}", $html_photo, $html);
  }
}

echo $html;
?>
