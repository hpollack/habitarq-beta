<?php
/**
 * =========================================
 *  Respaldo de base de datos.
 * =========================================
 * 
 * Este script, genera un respaldo automático de la base de datos, el cual es guardado
 * en un directorio externo al publico (que muestra la aplicacion). Utiliza el comando
 * mysqldump de MySQL en Linux. Se genera en la vista de configuracion
 * 
 * @version 1.0
 * @return 1 si se ha generado o 0 si ocurre un error.
**/ 
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