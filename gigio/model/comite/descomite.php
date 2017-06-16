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

$num = $_GET['num'];

$string = "update grupo set estado = 0 where numero = ".$num."";

$sql = mysqli_query($conn, $string);

if ($sql) {
	echo "1";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	       "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'delete', ".time().")";
}else {
	echo "0";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'error deleting', ".time().")";	
}


mysqli_query($conn, $log);
mysqli_close($conn);
?>