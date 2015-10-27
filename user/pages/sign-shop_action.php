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
}
else{
	if (isset($_POST["nombre"]))
		$nombre = utf8_decode($_POST["nombre"]);
	else
		$nombre = "";

	if (isset($_POST["address-street"]))
		$calle = utf8_decode($_POST["address-street"]);
	else
		$calle = "";

	if (isset($_POST["address-number"]))
		$numero = utf8_decode($_POST["address-number"]);
	else
		$numero = "";

	$direccion = $calle." ".$numero;

	if (isset($_POST["comuna"]))
		$comuna = $_POST["comuna"];
	else
		$comuna = "";

	$telefono = "";

	if (isset($_POST["telefono1"]))
		$telefono1 = $_POST["telefono1"];
	else
		$telefono1 = "0";

	if (isset($_POST["telefono2"]))
		$telefono2 = $_POST["telefono2"];
	else
		$telefono2 = "00000000";

	$telefono = "+56".$telefono1.$telefono2;

	if (isset($_POST["email"]))
		$email = utf8_decode($_POST["email"]);
	else
		$email = "";

	$days = "";

	if (isset($_POST["monday"])){
		$days .= $_POST["monday"];
		if (isset($_POST["tuesday"]) || isset($_POST["wednesday"]) || isset($_POST["thursday"]) || isset($_POST["friday"]) || isset($_POST["saturday"]) || isset($_POST["sunday"])) $days .= ", ";
	}	

	if (isset($_POST["tuesday"])){
		$days .= $_POST["tuesday"];
		if (isset($_POST["wednesday"]) || isset($_POST["thursday"]) || isset($_POST["friday"]) || isset($_POST["saturday"]) || isset($_POST["sunday"])) $days .= ", ";
	}

	if (isset($_POST["wednesday"])){
		$days .= $_POST["wednesday"];
		if (isset($_POST["thursday"]) || isset($_POST["friday"]) || isset($_POST["saturday"]) || isset($_POST["sunday"])) $days .= ", ";
	}

	if (isset($_POST["thursday"])){
		$days .= $_POST["thursday"];
		if (isset($_POST["friday"]) || isset($_POST["saturday"]) || isset($_POST["sunday"])) $days .= ", ";
	}

	if (isset($_POST["friday"])){
		$days .= $_POST["friday"];
		if (isset($_POST["saturday"]) || isset($_POST["sunday"])) $days .= ", ";
	}

	if (isset($_POST["saturday"])){
		$days .= $_POST["saturday"];
		if (isset($_POST["sunday"])) $days .= ", ";
	}

	if (isset($_POST["sunday"])){
		$days .= $_POST["sunday"];
	}

	$times = "";

	if (isset($_POST["time-start"]))
		$times .= $_POST["time-start"].":00";
	else
		$times .= "0:00";

	$times .= "-";

	if (isset($_POST["time-end"]))
		$times .= $_POST["time-end"].":00";
	else
		$times .= "0:00";

	$horario = $days." ".$times;

	if (isset($_POST["descripcion"]))
		$descripcion = utf8_decode($_POST["descripcion"]);
	else
		$descripcion = "";



	//Cargando Logo
	if (!empty($_FILES["logo"]["name"])){
		$logo_ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
		$cantidad_logos = getGlobal("cantidad_logos");
		$cantidad_logos = intval($cantidad_logos[0]->valor);
		$logo = "logo_".($cantidad_logos+1).".".$logo_ext;
		$target = "../../logos/".$logo;
		if (!move_uploaded_file($_FILES['logo']['tmp_name'], $target))
			$logo = null;
		else
			updateGlobal("cantidad_logos", $cantidad_logos+1);
	}
	else
		$logo = null;

	//Cargando Photo
	if (!empty($_FILES["photo"]["name"])){
		$photo_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
		$cantidad_photos = getGlobal("cantidad_photos");
		$cantidad_photos = intval($cantidad_photos[0]->valor);
		$photo = "photo_".($cantidad_photos+1).".".$photo_ext;
		$target = "../../photos/".$photo;
		if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target))
			$photo = null;
		else
			updateGlobal("cantidad_photos", $cantidad_photos+1);
	}
	else
		$photo = null;


	$usuario = $_SESSION["userid"];
	$id_local = setLocal($nombre, $direccion, $comuna, $telefono, $horario, $email, $logo, $photo, $descripcion, $usuario);

	//Seteando Rubros por Local
	$qRubros = intval($_POST["qRubros"]);
	$rubros = "";
	for ($i=1; $i<=$qRubros; $i++){
		if (isset($_POST["rubro-".$i]))
			setRubroLocal($id_local, $_POST["rubro-".$i]);
	}

	$html = file_get_contents("sign-shop_exito.html");
}

echo $html;
?>