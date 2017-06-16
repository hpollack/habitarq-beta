<?php
/*
=========================================
Respaldo de base de datos.
=========================================
*/ 
session_start();
include_once '../../../lib/php/config.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

date_default_timezone_set("America/Santiago");

if (PHP_SAPI == "CLI") {
	$salto = PHP_EOL;
}else{
	$salto = "<br>";
}

$host = $host;
$user = $user;
$pass = $pas;
$db   = $bd;

$fecha = date("Y-m-d", time());

$filename = "recabarius_".$fecha;

$cmd = "mysqldump --opt -h $host -u $user -p $pass $db > $filename.sql";

passthru($cmd, $salida);

echo $salida;


?>