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

$conn = conectar();

$us = $_GET['us'];

$string = "update usuarios set estado = 0 where idusuario = '".$us."'";

$sql = mysqli_query($conn, $string);

if ($sql) {
	echo "1";
}else {
	echo "0";
}

mysqli_close($conn);
?>