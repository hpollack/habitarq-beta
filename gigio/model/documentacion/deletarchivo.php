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

$id = $_POST['id'];
$nom = $_POST['nom'];

//Se separan todos los datos de la ruta absoluta
$ruta = explode('/', $nom);

$delete = "delete from documentos where id = ".$id."";

$sql =  mysqli_query($conn, $delete);

if ($sql) {
	# Se borra el archivo
	unlink($ruta[6]."/".$ruta[7]);

	echo "1";
}else {
	echo "0";
	//echo mysqli_error($conn);
}


?>