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

if (isset($_GET["dispositivo"]) && isset($_GET["id_local"]) && isset($_GET["nota"]) && !isset($_GET["update"])){
	$result = mysql_query("INSERT INTO calificaciones (dispositivo, id_local, nota) 
		VALUES ('".htmlspecialchars($_GET["dispositivo"])."', "
				.htmlspecialchars($_GET["id_local"]).", "
				.htmlspecialchars($_GET["nota"]).");");
}
else if (isset($_GET["dispositivo"]) && isset($_GET["id_local"]) && isset($_GET["nota"]) && isset($_GET["update"]))
	$result = mysql_query("UPDATE calificaciones SET nota = ".htmlspecialchars($_GET["nota"])." WHERE dispositivo = '".htmlspecialchars($_GET["dispositivo"])."' AND id_local = ".htmlspecialchars($_GET["id_local"]).";");

else if (isset($_GET["gcm"]) && isset($_GET["reg_id"]))
	$result = mysql_query("INSERT INTO gcm_regs (reg_id) VALUES ('".htmlspecialchars($_GET["reg_id"])."')");

else if (isset($_POST["version"]) && isset($_POST["comentario"]))
	$result = mysql_query("INSERT INTO version(comentario, fecha) VALUES ('".htmlspecialchars($_POST["comentario"])."', '".date("Ymd")."')");

else if (isset($_POST["ofertas"]) && isset($_POST["producto"]) && isset($_POST["precio"]) && isset($_POST["id_local"]))
	$result = mysql_query("INSERT INTO ofertas(id_local, oferta, precio) VALUES (".$_POST["id_local"].", ".htmlspecialchars($_POST["precio"]).", '".htmlspecialchars($_POST["producto"])."')");

else if (isset($_POST["visita"]) && isset($_POST["id_local"]) && isset($_POST["dateTime"]))
	$result = mysql_query("INSERT INTO visita_local(id_local, dateTime".(isset($_POST["dispositivo"]) ? ", dispositivo)" : ")")." VALUES (".$_POST["id_local"].", NOW()".(isset($_POST["dispositivo"]) ? ", '".$_POST["dispositivo"]."')" : ")"));

else if (isset($_POST["denuncia"]) && isset($_POST["id_local"]) && isset($_POST["comentario"]))
	$result = mysql_query("INSERT INTO denuncias(id_local, comentario) VALUES (".$_POST["id_local"].", '".htmlspecialchars($_POST["comentario"])."')");



if ($result) {
    // successfully inserted into database
    $response["success"] = 1;
    $response["message"] = "Operacion exitosa";
}
else{
    // failed to insert row
    $response["success"] = 0;
    $response["message"] = "Ha ocurrido un error";
}

print(json_encode($response));
mysql_close($con);

?>