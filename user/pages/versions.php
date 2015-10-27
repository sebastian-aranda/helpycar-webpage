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
      $html = file_get_contents("versions.html");
      $html = str_replace("{USERNAME}", $username, $html);

      $versiones = getVersiones();
      $html_versiones = "";
      $contador = 0;
      foreach ($versiones as $version){        
        $html_versiones .= "<tr><td>".++$contador.
          "</td><td>".utf8_encode($version->comentario).
          "</td><td>".utf8_encode($version->fecha).
          "</td></tr>";
      }
      
      $html = str_replace("{VERSIONES}", $html_versiones, $html);
    }
}

echo $html;

?>

