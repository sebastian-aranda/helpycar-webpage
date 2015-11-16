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

?>