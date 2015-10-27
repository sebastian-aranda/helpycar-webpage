<?php
require_once("../../../config.php");
require_once("../../../dist/class/class.connect.php");
require_once("../../../dist/functions/data.access.php");

$c_host = $databaselocation;
$c_user = $databaseuser;
$c_pass = $databasepass;
$c_db   = $databasename;

session_start();

if (!isset($_SESSION["loged"])){
	$html = file_get_contents("../../session_error.html");
	$html;
}
else{
	$message = $_GET["message"];
  	$gcm_regs = getGCMRegs();

  	include_once './GCM.php';
  	$gcm = new GCM();
  	foreach ($gcm_regs as $regs){
		$result = $gcm->send_notification($regs->reg_id, $message);
  	}

  	$result = TRUE;
  	echo $result; 	
}
?>