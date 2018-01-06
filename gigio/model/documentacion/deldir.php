<?php 
/*
  ===================================================================
  Borrar directorio
  ===================================================================   
 */
session_start();
include_once '../../lib/php/libphp.php';

if(!$_SESSION['rut']){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$id = $_POST['id'];

$salto = (PHP_SAPI == "CLI") ? PHP_EOL : "<br>";

$strdir = "select dir from documentos_cat where idcat = ".$id."";

$sql = mysqli_query($conn, $strdir);

if ($f = mysqli_fetch_array($sql)) {
	
	if (is_dir($f[0])) {
		# Se verifica si no contiene archivos
		$folder = @scandir($f[0]);
		if (count($folder) > 2) {
			# Mensaje de advertencia
			echo "2";
		} else {
			# Se borra el directorio y el registro de la base de datos.
			rmdir($f[0]);

			mysqli_query($conn, "delete from documentos_cat where idcat =".$id."");
			
			# Mensaje de OK
			echo "1";
		}
		
	} else {
		# Mensaje de error
		echo "3";
		exit();
	}
	
} else {
	#Mensaje de error;
	echo "0";
}
 mysqli_close($conn);

?>