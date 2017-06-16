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

$fecha = fechamy($_POST['fech']);
$motivo = mysqli_real_escape_string($conn, $_POST['mot']);

if($fecha == "") {
	echo "2";
	exit();
}

if ($motivo == "") {
	echo "3";
	exit();
}

$id = obtenerid("feriados", "idferiado");

$string = "insert into feriados (idferiado, dia, motivo) values(".$id.", ".strtotime($fecha).", '".$motivo."')";

$sql = mysqli_query($conn, $string);

if ($sql) {
	echo "1";
}else {
	echo "0";
	exit();
}

mysqli_close($conn);


 ?>