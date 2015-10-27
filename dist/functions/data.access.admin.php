<?php

function getUser($email){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM usuarios WHERE email = '$email'";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getCliente($id){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM usuarios WHERE id = $id";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getAdmin($id){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM admin WHERE id_usuario = $id";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getLocal($id){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM local WHERE id = $id";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getRubrosLocal($id_local){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM rubros_locales rl INNER JOIN rubros r ON rl.id_rubro = r.id WHERE id_local = $id_local";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function validateLocal($id, $nombre, $direccion, $comuna, $telefono, $email, $horario, $descripcion, $logo, $photo, $location){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "UPDATE local SET nombre = '$nombre', localizacion = '$location', direccion = '$direccion', comuna = '$comuna', telefono = '$telefono', horario = '$horario', mail = '$email', logo = '$logo', photo = '$photo', descripcion = '$descripcion', activo = 1 WHERE id = $id;";
	
	$database->setquery($sql);
	$database->query();
}

function getLocales($activo){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM local WHERE activo = $activo";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getRubro($id){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT r.* FROM rubros_locales rl INNER JOIN rubros r ON rl.id_rubro = r.id WHERE rl.id_local = $id";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getRubros(){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM rubros ORDER BY nombre";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getComuna($id){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM comunas WHERE id = $id";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getComunas(){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM comunas";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getVersiones(){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM version";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

?>