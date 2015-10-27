<?php
session_start();

if (!isset($_SESSION["loged"]))
    $html = file_get_contents("../session_error.html");
else{
    require_once("../../config.php");
    require_once("../../dist/class/class.connect.php");
  	require_once("../../dist/functions/data.access.php");
  	require_once("../../dist/functions/functions.php");

  	$c_host = $databaselocation;
  	$c_user = $databaseuser;
  	$c_pass = $databasepass;
  	$c_db   = $databasename;
    
    $username = $_SESSION["username"];
    $html = file_get_contents("index.html");
    $html = str_replace("{USERNAME}", $username, $html);

    $user = $_SESSION["userid"];
    $premium = $_SESSION["premium"];
    $locales = getLocales($user);
    $html_locales = "";
    $contador = 0;
    $contador_locales = 0;
    foreach ($locales as $local){
      $contador_locales++;
    	$rating = getRating($local->id);
      $norating = 5-$rating;
      $stars = "";
      
      for ($i=0; $i<$rating; $i++)
        $stars .= "<span class='glyphicon glyphicon-star' aria-hidden='true' style='color:yellow;'></span>";

      for ($i=0; $i<$norating; $i++)
        $stars .= "<span class='glyphicon glyphicon-star' aria-hidden='true' style='color:gray;'></span>";
      
      if ($local->activo == 1)
        $estado = "<span class='glyphicon glyphicon-ok' aria-hidden='true' style='color:green;'></span>";
      else
        $estado = "<span class='glyphicon glyphicon-remove' aria-hidden='true' style='color:red;'></span>";

      $acciones = "<a href='update-shop.php?local=".$local->id."'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a>&nbsp;"
        ."<a href='#deleteDialogBox' onclick='deleteDialogBox(".$local->id.", \"".utf8_encode($local->nombre)."\"); return false;'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";

      $html_locales .= "<tr><td>".++$contador."</td><td>".utf8_encode($local->nombre)."</td><td>".$estado."</td><td>".$stars."</td><td>".$acciones."</td></tr>";
    }
    $html = str_replace("{LOCALES}", $html_locales, $html);

    $_SESSION["cantidad_locales"] = $contador_locales;
    $agregar_local = false;
    
    /*  Cantidad de Locales por paquete premium  */
    $localesPremium = [1,3,10,30,999];
    if ($localesPremium[$premium] > $contador_locales)
      $agregar_local = true;

    if ($agregar_local){
      $html_agregar_local = "<a class='btn btn-primary' href='sign-shop.php'>Agregar Local</a>";
      $html = str_replace("{SIGN_SHOP_PERMISSION}", "", $html);
      $html = str_replace("{SIGN_SHOP_LINK}", "sign-shop.php", $html);
    } 
    else{
      $html_agregar_local = "<p style='color:red;'>Usted pude agregar como máximo ".$localesPremium[$premium]." local". ($premium > 0 ? "es" : "").". Para agregar otro local debe mejorar su cuenta premium</p>";
      $html = str_replace("{SIGN_SHOP_PERMISSION}", "disabled", $html);
      $html = str_replace("{SIGN_SHOP_LINK}", "javascript: void(0)", $html);
    }

    $html = str_replace("{AGREGAR_LOCAL}", $html_agregar_local, $html);

}

echo $html;

?>

