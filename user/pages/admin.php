<?php
session_start();

if (!isset($_SESSION["loged"]))
    $html = file_get_contents("../session_error.html");
else{
    require_once("../../config.php");
    require_once("../../dist/class/class.connect.php");
  	require_once("../../dist/functions/data.access.admin.php");

  	$c_host = $databaselocation;
  	$c_user = $databaseuser;
  	$c_pass = $databasepass;
  	$c_db   = $databasename;

    //RESTRINGIR SI ES UN USUARIO ADMIN
    $user = $_SESSION["userid"];
    $admin = getAdmin($user);
    $admin = $admin[0];
    if (!$admin){
      $html = file_get_contents("admin_error.html");
    }
    else{
      $username = $_SESSION["username"];
      $html = file_get_contents("admin.html");
      $html = str_replace("{USERNAME}", $username, $html);

      $activos = getLocales(1);
      $html_locales = "";
      $contador = 0;
      foreach ($activos as $local){
        //$aux = getRubro($local->id);
        //$rubro = $aux[0]->nombre;
        //Optimizar

        $aux = getComuna($local->comuna);
        $comuna = $aux[0]->nombre;

        $aux = getCliente($local->usuario);
        $cliente = $aux[0]->nombre;

        $acciones = "<a href='#'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
        
        $html_locales .= "<tr><td>".++$contador.
          "</td><td>".utf8_encode($local->nombre).
          "</td><td>".utf8_encode($local->direccion).
          "</td><td>".utf8_encode($comuna).
          "</td><td>".$local->telefono.
          "</td><td>".$local->horario.
          "</td><td>".$local->mail.
          "</td><td>".utf8_encode($local->descripcion).
          "</td><td>".utf8_encode($cliente).
          "</td><td>".$acciones.
          "</td></tr>";
      }
      
      $html = str_replace("{LOCALES_ACTIVOS}", $html_locales, $html);

      $inactivos = getLocales(0);
      $html_locales = "";
      $contador = 0;
      foreach ($inactivos as $local){
        //$aux = getRubro($local->tipo);
        //$rubro = $aux[0]->nombre;
        //Optimizar

        $aux = getComuna($local->comuna);
        $comuna = $aux[0]->nombre;

        $aux = getCliente($local->usuario);
        $cliente = $aux[0]->nombre;

        $acciones = "<a href='validate-shop.php?local=".$local->id."'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></a>&nbsp;"
          ."<a href='#'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
        
        $html_locales .= "<tr><td>".++$contador.
          "</td><td>".utf8_encode($local->nombre).
          "</td><td>".utf8_encode($local->direccion).
          "</td><td>".utf8_encode($comuna).
          "</td><td>".$local->telefono.
          "</td><td>".$local->horario.
          "</td><td>".$local->mail.
          "</td><td>".utf8_encode($local->descripcion).
          "</td><td>".utf8_encode($cliente).
          "</td><td>".$acciones.
          "</td></tr>";
      }
      
      $html = str_replace("{LOCALES_INACTIVOS}", $html_locales, $html);
    }
}

echo $html;

?>

