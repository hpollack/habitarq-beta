<?php 
session_start();
include_once '../../lib/php/libphp.php';
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