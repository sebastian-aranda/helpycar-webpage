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
  
  $username = $_SESSION["username"];
  $premium = $_SESSION["premium"];
  $cantidad_locales = $_SESSION["cantidad_locales"];
  
  //Verificar permiso agregar local
  $localesPremium = [1,3,10,30,999];

  if ($localesPremium[$premium] <= $cantidad_locales)
    die("<script>alert('Para poder agregar mas locales debe mejorar su membresia');window.location.href = 'index.php';</script>");
  
  $html = file_get_contents("sign-shop.html");
  $html = str_replace("{USERNAME}", $username, $html);
  $html = str_replace("{PREMIUM}", $premium, $html);

  $rubros = getRubros();
  $html_rubros = "";
  foreach ($rubros as $rubro){
    $html_rubros .= "<option value='".$rubro->id."'>".$rubro->nombre."</option>";
  }
  $html = str_replace("{RUBROS}", $html_rubros, $html);

  $comunas = getComunas();
  $html_comunas = "";
  foreach ($comunas as $comuna){
    $html_comunas .= "<option value='".$comuna->id."'>".$comuna->nombre."</option>";
  }
  $html = str_replace("{COMUNAS}", $html_comunas, $html);

  $html_horarios = "";
  for ($i=0; $i<24; $i++)
    $html_horarios .= "<option value='".$i."'>".$i.":00</option>";
  $html = str_replace("{HORARIOS}", $html_horarios, $html);

  $maxDescPremium = [150, 350, 500, 600, 600];
  $html = str_replace("{NUM_CARACTER}", $maxDescPremium[$premium], $html);

  //Mostrar Logo
  $html = str_replace("{SHOW_LOGO}", "<img class='logo' src='http://placehold.it/100' alt='no logo'>", $html);

  // Verificar permiso de agregar Logo
  if ($premium > 0)
    $html_logo = "<input name='logo' id='logo' type='file'>";
  else
    $html_logo = "<p style='color:red;'>Para poder agregar un logo debe contar con membresía premium</p>";

  $html = str_replace("{LOGO_PERMISSION}", $html_logo, $html);

  //Mostrar Foto
  $html = str_replace("{SHOW_PHOTO}", "<img class='photo' src='http://placehold.it/300x200' alt='no photo'>", $html);

  // Verificar permiso de agregar foto
  if ($premium >= 2)
    $html_photo = "<input name='photo' id='photo' type='file'>";
  else if ($premium == 0)
    $html_photo = "<p style='color:red;'>Para poder agregar una foto debe contar con una membresía premium</p>";
  else
    $html_photo = "<p style='color:red;'>Para poder agregar una foto debe mejorar su membresía premium</p>";

  $html = str_replace("{PHOTO_PERMISSION}", $html_photo, $html);



}

echo $html;
?>
