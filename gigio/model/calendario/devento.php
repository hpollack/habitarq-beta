<?php 

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
	# code...
	echo "1";
}else{

	echo "0";
	exit();
}

mysqli_close($conn);

?>