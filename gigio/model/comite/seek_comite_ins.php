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

$num = $_POST['num'];

$string = "select idgrupo, nombre from grupo where numero = ".$num."";

$sql  = mysqli_query($conn, $string);

if ($f = mysqli_fetch_array($sql)) {
	
	$id  = $f[0];
	$nom = $f[1];
}else{
	$id  = null;
	$nom = null;
}

if ($sql) {
	$datos = array('midg' => $id, 'nomb' => $nom );
	echo json_encode($datos);
}else{
	echo "Error";
}

mysqli_close($conn);

?>