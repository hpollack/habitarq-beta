<?php
/**
*=====================================================================
* 					Subida de Archivos
*=====================================================================
* Este codigo es para la subida de archivos multiples (1 a n)
* Al subir el archivo, genera un registro en la base de datos, siempre y cuando
* No tenga el mismo nombre o no exista uno idem.
* Se debe considerar, los permisos de escritura a la hora de implementar.
* De no hacerlo, el programa detendrá su funcionamiento y generará error.
* 
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

$directorio = mysqli_fetch_row(mysqli_query($conn, "select dir from documentos_cat where idcat = ".$id.""));

$dir = $directorio[0]."/";

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

				#Se verifica si existe un documento con el mismo nombre.
				$iguales = mysqli_num_rows(mysqli_query($conn, "select * from documentos where nombre = '".$original."'"));

				if ($iguales == 0) {
					#Finalmente se mueven los archivos temporales y se genera el enlace
					move_uploaded_file($temporal, $destino);			
				}

				if ($k['error'] == '') {
					# Si no viene ningun error
					$ndoc = obtenerid("documentos", "id");
					$file = mysqli_fetch_row(mysqli_query($conn, "select * from documentos where nombre = '".$original."'"));
					
					if ((!$file[1]) || ($file[1] != $original)) {
						# Si el archivo no existe o es distinto a uno que ya está, se inserta la fila en la base de datos.
						$string = "insert into documentos(id, nombre, enlace, directorio) values(".$ndoc.", '".$k['name']."', '".url()."model/documentacion/".$destino."', ".$id.")";
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
					
				} else {

					# Error de subida
					$msg .=" Ocurrio un error al subir el archivo <b>".$original."</b> por el siguiente error: \n".$k['error'];
				}
			} else {

				# Error de creación de directorio
				$msg .= "No se pudo crear el directorio<br>";
			}
		} else {

			# Error de archivo
			$msg .= "No es un archivo valido</br>";
		}
	} else {

		# Error al enviar un vacio
		$msg .= "No ha subido ningun archivo</br>";
	}
}

echo $msg;

mysqli_close($conn);

?>