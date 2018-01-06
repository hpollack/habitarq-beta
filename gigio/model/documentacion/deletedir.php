<?php 
/*
  ===================================================================
   Limpiador de directorios vacíos en documentacion
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

$salto = (PHP_SAPI == "CLI") ? PHP_EOL : "<br>";

$strdir = "select * from documentos_cat";

$sql = mysqli_query($conn, $strdir);

while ($dir = mysqli_fetch_array($sql)) {
	
	if (is_dir($dir[1])) {
		
		$folder = @scandir($dir[1]);

		if (count($folder) > 2) {
			# Si tiene archivos
			echo "El directorio ".$dir[1]." tiene archivos".$salto;
		} else {
			# Ver si el directorio no tiene asociado otros.
			$pnt = mysqli_query($conn, "select * from documentos_cat where parent = ".$dir[0]."");
			
			if (mysqli_num_rows($pnt) > 0) {
				
				echo "El directorio ".$dir[1]." contiene subdirectorios".$salto;
				continue;
			} else {
				# Si no contiene ninguno, se borra
				@rmdir($dir[1]);

				# Se debe borrar tambien el registro en la base de datos.
				$deldata = mysqli_query($conn, "delete from documentos_cat where idcat = ".$dir[0]." and parent <> 0");

				echo "Se borró el directorio ".$dir[1].$salto;
			}
			
		}
		 
	} else {

		echo "El directorio no existe".$salto;
		$deldata = mysqli_query($conn, "delete from documentos_cat where idcat = ".$dir[0]."");
	}
}
?>