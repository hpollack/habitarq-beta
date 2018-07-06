<?php 
include_once 'libphp.php';

$conn = conectar();

$id = 1;

$salto = (PHP_SAPI == "CLI") ? PHP_EOL : "<br>";

$sql = mysqli_query($conn, "select * from vivienda");

while ($f = mysqli_fetch_array($sql)) {
	# code...
	$actualizar = mysqli_query($conn, "update vivienda set idvivienda = ".$id." where rol = '".$f[1]."';");

	echo "Actualizando id ".$id." de vivienda ".$f[1].$salto;

	$id++;
}

mysqli_close($conn);
exit(0);


?>

