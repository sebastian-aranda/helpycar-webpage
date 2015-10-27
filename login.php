<?php


require_once("config.php");
require_once("dist/class/class.connect.php");
require_once("dist/functions/data.access.php");

$c_host = $databaselocation;
$c_user = $databaseuser;
$c_pass = $databasepass;
$c_db   = $databasename;

$email = $_POST["email"];
$password = $_POST["password"];



if (!validateUser($email, $password))
	$html = file_get_contents("login_error.html");

else{
	$html = file_get_contents("user/index.html");
	$user = getUser($_POST["email"]);

	session_start();
	$_SESSION["username"] = $user[0]->nombre;
	$_SESSION["userid"] = $user[0]->id;
	$_SESSION["premium"] = $user[0]->premium;
	$_SESSION["loged"] = 1;
}

echo $html;
?>