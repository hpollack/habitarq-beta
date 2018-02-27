<?php
/**
*=====================================================================
* 					Subida de Archivos
*=====================================================================
* Este codigo es para la subida de archivos multiples (1 a n)
* Para crear directorios, se deben generar permisos especiales en el servidor.
*@author Hermann Pollack
**/ 
session_start();

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

include '../../lib/php/libphp.php';

$conn = conectar();

$id = $_GET['id']; // Esta id se debe pasar por get, en la funcion ajax de jquery

$comite = mysqli_fetch_row(mysqli_query($conn, "select numero from grupo where idgrupo = ".$id.""));

$nom = explode(' ', $comite[0]);

$dir = $comite[0]."/";

foreach ($_FILES as $k) {
	
	# Se extraen los archivos desde el arreglo.
	if ($k['error'] == UPLOAD_ERR_OK) {
		
		# Sse comprueba el tipo de archivo
		if ($k['type']=="application/msword"||$k['type']=="application/vnd.ms-excel"||$k['type']=="application/pdf"||$k['type']=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"||$k['type']=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"||$k['type']=="image/jpg"||$k['type']=="image/jpeg"||$k['type']=="image/png") {
			
			# Se comprueba si existe el directorio o si se puede crear
			if (file_exists($dir) || @mkdir($dir)) {
				# Se setean los los archivos
				$original = $k['name']; //Nombre del archivo temporal

				# Se genera un archivo temporal en caché para la subida.
				$temporal = $k['tmp_name'];

				#Se crea el enlace
				$destino  = $dir.$k['name'];

				#Finalmente se mueven los archivos temporales y se genera el enlace
				move_uploaded_file($temporal, $destino);

				if ($k['error'] == '') {
					# Si no viene ningun error
					$ndoc = obtenerid("documentos_obra", "iddocumento");
					$file = mysqli_fetch_row(mysqli_query($conn, "select * from documentos_obra where nombredoc = '".$original."'"));
					
					if ((!$file[1]) || ($file[1] != $original)) {
						# code...
						$string = "insert into documentos_obra(iddocumento, nombredoc, link, idgrupo) values(".$ndoc.", '".$k['name']."', '".url()."model/obras/".$destino."', ".$id.")";
						$sql = mysqli_query($conn, $string);

						if (!$sql) {
						
							echo "<b>Ocurrió un error en la transacción</b>";
							exit();
						}
					} else {
						// Si existe el archivo con el mismo nombre.
						$msg .=	"Archivo <b>".$original."</b> Ha sido modificado correctamente.<br>";	
						continue;
					}					

					$msg .= "Archivo <b>".$original."</b> Subido correctamente.<br>";
					# Mensaje de Ok.
					
				}else {

					# Error de subida
					$msg .=" Ocurrio un error al subir el archivo <b>".$original."</b> por el siguiente error: \n".$k['error'];
				}
			}else {

				# Error de creación de directorio
				$msg .= "No se pudo crear el directorio<br>";
			}
		}else {

			# Error de archivo
			$msg .= "No es un archivo valido</br>";
		}
	}else {

		# Error al enviar un vacio
		$msg .= "No ha subido ningun archivo</br>";
	}
}

echo $msg;

mysqli_close($conn);

?>