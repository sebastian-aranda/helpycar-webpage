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
    $html = file_get_contents("add-offer.html");
    $html = str_replace("{USERNAME}", $username, $html);

    $user = $_SESSION["userid"];
    $premium = $_SESSION["premium"];
    $ofertasPremium = [1,2,3,4,5];
    $maxOffer = $ofertasPremium[$premium];
    $locales = getLocales($user);
    $html_locales = "";
    $contador_locales = 0;
    foreach ($locales as $local){
      $contador_locales++;
      $html_locales .= "<div class='panel panel-default'><div class='panel-heading'><strong>".$local->nombre."</strong><span style='float:right;'>Ofertas Restantes: <span class='num-offer'>{#OFERTAS}</span> <input class='reference' value='".($contador_locales-1)."' type='hidden'><button type='button' class='btn btn-default btn-xs btn-add-offer'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></button></span></div><table class='table'><thead><tr><th>#</th><th>Producto</th><th>Precio</th></tr></thead>{OFERTAS}<tr class='new-offer'><td><input class='id_local' value='".$local->id."' type='hidden'><button type='button' class='btn btn-primary btn-sm btn-save-offer'>Agregar</button></td><td><input class='producto' type='text'></td><td><input class='precio' type='text'></td></tr></table></div>";

      $ofertas = getOfertas($local->id);
      $html_ofertas = "";
      $contador_ofertas = 0;
      foreach ($ofertas as $oferta){
        $contador_ofertas++;
        $html_ofertas .= "<tr><td>".$contador_ofertas."</td><td>".$oferta->oferta."</td><td>".$oferta->precio."</td></tr>";
      }

      $html_locales = str_replace("{#OFERTAS}", ($maxOffer-$contador_ofertas), $html_locales);
      $html_locales = str_replace("{OFERTAS}", $html_ofertas, $html_locales);
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

