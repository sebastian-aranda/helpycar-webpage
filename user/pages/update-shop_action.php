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
	if (isset($_POST["id"]))
		$id = $_POST["id"];
	else
		$id = 0;	

	if (isset($_POST["nombre"]))
		$nombre = utf8_decode($_POST["nombre"]);
	else
		$nombre = "";

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
		if (isset($_POST["tuesday"]) || isset($_POST["wednesday"]) || isset($_POST["thursday"]) || isset($_POST["friday"]) || isset($_POST["saturday"])) $days .= ", ";
	}	

	if (isset($_POST["tuesday"])){
		$days .= $_POST["tuesday"];
		if (isset($_POST["wednesday"]) || isset($_POST["thursday"]) || isset($_POST["friday"]) || isset($_POST["saturday"])) $days .= ", ";
	}

	if (isset($_POST["wednesday"])){
		$days .= $_POST["wednesday"];
		if (isset($_POST["thursday"]) || isset($_POST["friday"]) || isset($_POST["saturday"])) $days .= ", ";
	}

	if (isset($_POST["thursday"])){
		$days .= $_POST["thursday"];
		if (isset($_POST["friday"]) || isset($_POST["saturday"])) $days .= ", ";
	}

	if (isset($_POST["friday"])){
		$days .= $_POST["friday"];
		if (isset($_POST["saturday"])) $days .= ", ";
	}

	if (isset($_POST["saturday"])){
		$days .= $_POST["saturday"];
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

	//Eliminando Rubros
	if (isset($_POST["rubros-deleted"])){
		$id_rubros_deleted = $_POST["rubros-deleted"];
		foreach($id_rubros_deleted as $id_rubro_deleted)
		deleteRubroLocal($id, $id_rubro_deleted);
	}

	//Seteando Rubros por Local
	$qRubros = intval($_POST["qRubros"]);
	$rubros = "";
	for ($i=1; $i<=$qRubros; $i++){
		if (isset($_POST["rubro-".$i]))
			setRubroLocal($id, $_POST["rubro-".$i]);
	}

	$local = getLocal($id);
	$local = $local[0];

	//Cargando Logo
	if (!empty($_FILES["logo"]["name"])){
		$logo_ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
		$logo = $local->logo;
		if ($logo == null){
			$cantidad_logos = getGlobal("cantidad_logos");
			$cantidad_logos = intval($cantidad_logos[0]->valor);
			$logo = "logo_".($cantidad_logos+1).".".$logo_ext;
			$target = "../../logos/".$logo;
			updateGlobal("cantidad_logos", $cantidad_logos+1);
		}
		else{
			$target = "../../logos/".$logo;
			@unlink($target);
		}

		if (!move_uploaded_file($_FILES['logo']['tmp_name'], $target))
			$logo = null;
			
	}
	else
		$logo = $local->logo;

	//Cargando Photo
	if (!empty($_FILES["photo"]["name"])){
		$photo_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
		$photo = $local->photo;
		if ($photo == null){
			$cantidad_photos = getGlobal("cantidad_photos");
			$cantidad_photos = intval($cantidad_photos[0]->valor);
			$photo = "photo_".($cantidad_photos+1).".".$photo_ext;
			$target = "../../photos/".$photo;
			updateGlobal("cantidad_photos", $cantidad_photos+1);
		}
		else{
			$target = "../../photos/".$photo;
			@unlink($target);
		}
		
		if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target))
			$photo = null;
	}
	else
		$photo = $local->photo;
	
	$usuario = $_SESSION["userid"];
	updateLocal($id, $nombre, $telefono, $email, $logo, $photo, $horario, $descripcion);

	$html = file_get_contents("update-shop_exito.html");
}

echo $html;
?>