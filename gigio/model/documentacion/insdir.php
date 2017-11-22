<?php 
session_start();
include_once '../../lib/php/libphp.php';

if(!$_SESSION['rut']){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$dir = mysqli_real_escape_string($conn, $_POST['dir']);
if (empty($dir)) {
	# Mensaje de error
	echo "2";
	exit();
}

$id = obtenerid("documentos_cat","idcat"); //Trae la ultima id.

$string = "insert into documentos_cat(idcat, dir, parent) values(".$id.", '".$dir."',0)";

$sql = mysqli_query($conn, $string);

if ($sql) {
	# Crea el directorio.
	mkdir($dir);
	echo "1";
}else {
	# Mensaje de error
	echo "0";
}

?>

