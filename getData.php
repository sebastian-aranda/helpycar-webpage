<?php
error_reporting(0);
require_once("config.php");
$c_host = $databaselocation;
$c_user = $databaseuser;
$c_pass = $databasepass;
$c_db   = $databasename;

$con = mysql_connect($c_host,$c_user,$c_pass);

if (!$con){
	die('Could not connect: ' . mysql_error());
}

mysql_select_db($c_db, $con);

if (isset($_GET["id"])){
	$result = mysql_query("SELECT * FROM local WHERE id ='" . htmlspecialchars($_GET["id"]) . "'");
}
else if (isset($_GET["tipo"])){
	$result = mysql_query("SELECT * FROM local WHERE tipo ='" . htmlspecialchars($_GET["tipo"]) . "'");
}
else if (isset($_GET["version"])){
	$result = mysql_query("SELECT local.*,usuarios.premium as premium, (SELECT id FROM version ORDER BY id DESC LIMIT 1) as version_id, (SELECT comentario FROM version ORDER BY id DESC LIMIT 1) as version_comentario FROM local INNER JOIN usuarios ON local.usuario = usuarios.id WHERE local.activo = 1");
}
else if (isset($_GET["calificacion"])){
	$result = mysql_query("SELECT * FROM calificaciones");
}
else if (isset($_GET["rubros"])){
	$result = mysql_query("SELECT * FROM rubros_locales");
}
else{
	$result = mysql_query("SELECT local.*, usuarios.premium as premium FROM local INNER JOIN usuarios ON local.usuario = usuarios.id WHERE local.activo = 1;");
}

while($row = mysql_fetch_assoc($result)){
	$output[]=array_map('utf8_encode',$row);
}

print(json_encode($output));
mysql_close($con);

?>