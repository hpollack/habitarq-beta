<?php 
include_once 'libphp.php';

$conn = conectar();

$id = 1;

$salto = (PHP_SAPI == "CLI") ? PHP_EOL : "<br>";

$sql = mysqli_query($conn, "select * from cuenta");

while ($f = mysqli_fetch_array($sql)) {
	# code...
	$actualizar = mysqli_query($conn, "update cuenta set idcuenta = ".$id." where ncuenta = ".$f[1].";");

	echo "Actualizando id ".$id." de cuenta ".$f[1].$salto;

	$id++;
}

mysqli_close($conn);
exit(0);

?>