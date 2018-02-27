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

/*if (PHP_SAPI == "CLI") {
	$salto = PHP_EOL;
}else{
	$salto = "<br>";
}*/

$dia = $_POST['dia'];

$host = $host;
$user = $user;
$pass = $pas;
$db   = $bd;

$fecha = date("Y-m-d", time());

$filename = "recabarius_".$fecha;

$cmd = "mysqldump -h {$host} -u {$user} -p{$pass} {$db} > /var/www/bckp/{$filename}.sql";

system($cmd,$rval);

if ($rval == 0) {
	
	echo "1";
} else {
	
	echo "0";
	exit();
}

?>