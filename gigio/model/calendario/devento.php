<?php 
/* Borra un evento de la base de datos. */
session_start();
date_default_timezone_set("America/Santiago");
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

$id = $_POST['id'];

$string = "delete from eventos_calendario where idevento = ".$id."";

$sql = mysqli_query($conn, $string);

if ($sql) {
	# Si es verdadero
	echo "1";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	       "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'del evento', ".time().");";

	mysqli_query($conn, $log);
}else{
	# Si es falso
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	       "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'error del', ".time().");";

	mysqli_query($conn, $log);

	exit();
}

mysqli_close($conn);

?>