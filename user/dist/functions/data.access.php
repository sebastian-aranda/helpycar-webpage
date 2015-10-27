<?php

function getUser($email){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM usuarios WHERE email = $email";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

function setUser($name, $email, $password){
	global $c_host,$c_user,$c_pass,$c_db;	

	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "INSERT INTO usuarios(nombre, email, password) VALUES ('$name', '$email', '$password');";
					   
	$database->setquery($sql);
	$database->query();	
}

function validateUser($email, $password){
	global $c_host,$c_user,$c_pass,$c_db;
	
	$database = new database($c_host,$c_user,$c_pass);
	$database->setDb($c_db);
	
	$sql = "SELECT * FROM usuarios WHERE email = $email and password = $password";

	$database->setquery($sql);
	$database->query();	
	$result = $database->listObjects();
	return $result;
}

?>