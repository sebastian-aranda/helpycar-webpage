<?php
require_once("../../config.php");
require_once("../../dist/class/class.connect.php");
require_once("../../dist/functions/data.access.php");

$c_host = $databaselocation;
$c_user = $databaseuser;
$c_pass = $databasepass;
$c_db   = $databasename;

session_start();

if (!isset($_SESSION["loged"])){
	$html = file_get_contents("../session_error.html");
	echo $html;
}
else{
	$id_local = $_POST["id"];
  	$local = getLocal($id_local);
  	
  	if ($local){
    	$local = $local[0];
    	$owner = $local->usuario; 
  	}
  	else
    	$owner = 0;
  
  	$userid = $_SESSION["userid"];

  	if ($userid != $owner){
  		die("Usted no puede borrar este local");
  	}
  	else{
  		deleteLocal($id_local);
  		die("Local borrado exitósamente");
  	}
}
?>