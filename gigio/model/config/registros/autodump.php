<?php 
session_start();

include_once '../../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$dbd = $_POST['dbd'];

$filename = "recabarius_".$fecha; //Nombre del respaldo

$salto = (PHP_SAPI == "CLI") ? PHP_EOL : "<br>";

if ($dbd == 0) {

	echo "0";
	exit();
} else {
	# Seteamos fecha actual
	$fecha = time();

	# Se trae fecha almacenada en la base de datos.
	$fecha_respaldo = traerValorConfig("fecharespaldodb");

	if (date("Y/m/d",$fecha_respaldo) == date("Y/m/d", $fecha)) {
	 	
	 	# Se ejecuta el comando.
	 	$bckp = respaldoDB();

	 	if ($bckp != 1) {

	 		# Si es falso, se advierte que no se realizó el respaldo
	 		echo "No se pudo realizar el respaldo";
	 		exit();
	 	}

	 	# Obtener valor de configuración para actualizar fecha.

	 	$dias = traerValorConfig("RegDB");

	 	# Se actualiza la fecha de respaldo
	 	$update = configRespaldo($dias);

	 	if ($update == 1) {

	 		#Se trae la fecha de respaldo
	 		$fecha_nueva = date("d/m/Y", traerValorConfig("fecharespaldodb"));

	 		echo "Nueva Fecha de Respaldo: ".$fecha_nueva;
	 	} else {
	 		# code...
	 		echo "Ocurrió un error al actualizar la fecha";
	 		exit();
	 	}

	 	
	 } else {
	 	
	 	echo "Ocurrió un error general";
	 	exit();
	 }	  
}
?>