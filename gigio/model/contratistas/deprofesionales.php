<?php

session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$rut = explode("-", $_POST['rut']);

$string = "update profesionales set estado = 0 where rutprof = '".$rut[0]."'";

$sql = mysqli_query($conn, $string);

if ($sql) {
	# Verdadero
	echo "1";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/contratistas/index.php', 'delete', ".time().");";
	mysqli_query($conn, $log);	
} else {
	# Falso
	echo "0";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/contratistas/index.php', 'error delete', ".time().");";
	mysqli_query($conn, $log);
	exit();
}

mysqli_close($conn);

?>