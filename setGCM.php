<?php
$con = mysql_connect("localhost","dicomtec_user","291092sas");

if (!$con){
	die('Could not connect: ' . mysql_error());
}

mysql_select_db("dicomtec_helpycar", $con);

if (isset($_GET["gcm_register"]) && isset($_GET["reg_id"])){
	$result = mysql_query("INSERT INTO gcm_regs (reg_id) VALUES ('".htmlspecialchars($_GET["reg_id"])."')");
}

if ($result) {
    // successfully inserted into database
    $response["success"] = 1;
    $response["message"] = "Registro GCM exitoso";
}
else{
    // failed to insert row
    $response["success"] = 0;
    $response["message"] = "Ha ocurrido un error";
}

print(json_encode($response));
mysql_close($con);

?>