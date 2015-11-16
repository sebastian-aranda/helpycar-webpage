<?php

function getCliente($email){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM clientes WHERE email = '$email'";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getClienteById($id){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM clientes WHERE id = $id";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function setCliente($name, $email, $password){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "INSERT INTO clientes(nombre, email, password) VALUES ('$name', '$email', '$password');";
					   
	$database->setquery($sql);
	$database->query();	
}

function validateCliente($email, $password){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM clientes WHERE email = '$email' and password = '$password'";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getLocal($id){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM locales WHERE id = $id";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getLocales($cliente){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM locales WHERE cliente = $cliente";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getOfertas($id){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM ofertas WHERE id_local = $id";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function getGlobal($global){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM globals WHERE nombre = '$global'";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function updateGlobal($global, $new_value){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "UPDATE globals SET valor = '$new_value' WHERE nombre = '$global'";
					   
	$database->setquery($sql);
	$database->query();	
}

function setLocal($nombre, $direccion, $comuna, $telefono, $horario, $email, $logo, $photo, $descripcion, $cliente){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "INSERT INTO locales(nombre, direccion, comuna, telefono, horario, mail, ".($logo != null ? "logo, " : "").($photo != null ? "photo, " : "")."descripcion, cliente) 
		VALUES ('$nombre', '$direccion', $comuna, '$telefono', '$horario', '$email', ".($logo != null ? "'$logo', " : "").($photo != null ? "'$photo', " : "")."'$descripcion', $cliente);";
					   
	$database->setquery($sql);
	$database->query();	

	return mysql_insert_id();
}

function updateLocal($id, $nombre, $telefono, $email, $logo, $photo, $horario, $descripcion){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "UPDATE locales SET nombre = '$nombre', telefono = '$telefono', horario = '$horario', mail = '$email', ".($logo != null ? "logo = '$logo', " : "").($photo != null ? "photo = '$photo', " : "")."descripcion = '$descripcion' WHERE id = $id";
					   
	$database->setquery($sql);
	$database->query();	
}

function deleteLocal($id){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "DELETE FROM locales WHERE id = $id;";
	$sql2 = "DELETE FROM rubros_locales WHERE id_local = $id;";
	$sql3 = "DELETE FROM calificaciones WHERE id_local = $id;";
					   
	$database->setquery($sql);
	$database->query();
	$database->setquery($sql2);
	$database->query();
	$database->setquery($sql3);
	$database->query();
}

function getCalificaciones($id_local){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM calificaciones WHERE id_local = $id_local";

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

function setRubroLocal($id_local, $id_rubro){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "INSERT INTO rubros_locales(id_local, id_rubro) VALUES ($id_local, $id_rubro);";
					   
	$database->setquery($sql);
	$database->query();	
}

function deleteRubroLocal($id_local, $id_rubro){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "DELETE FROM rubros_locales WHERE id_local = $id_local AND id_rubro = $id_rubro;";
	//$sql4 = "INSERT INTO version(comentario) VALUES ('Local $id eliminado');";
					   
	$database->setquery($sql);
	$database->query();
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

?>