<?php

require_once("config.php");
require_once("dist/class/class.connect.php");
require_once("dist/functions/data.access.php");

$c_host = $databaselocation;
$c_user = $databaseuser;
$c_pass = $databasepass;
$c_db   = $databasename;

if (isset($_POST["name"]))
	$name = $_POST["name"];
else
	$name = "";

if (isset($_POST["email"]))
	$email = $_POST["email"];
else
	$email = "";

if (isset($_POST["password"]))
	$password = $_POST["password"];
else
	$password = "";


$user = getUser($email);
if (!$user)
	setUser($name, $email, $password);
else
	echo "<script>window.location.href = 'register_error.html'</script>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Helpycar</title>
</head>
<body>
	<script type="text/javascript">
	  alert("Registro exitoso!");
      window.opener.location.href = "index.html";
      window.close();
    </script>
</body>
</html>