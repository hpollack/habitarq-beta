<?php 

/**
* ==========================================================
*  SETEO Y ACTUALIZACION DE VARIABLES DE CONFIGURACION DE 
*  MANTENCION DE REGISTROS Y LOS RESPALDOS DE LA 
*  BASE DE DATOS
* ==========================================================
* 
* Script que actualiza los valores de configuración para los respaldos de la base de datos, además de
* la cantidad de dias en que se mantendrán los registros del sistema, junto con la cantidad de días en que se ejecutara
* el nuevo respaldo de la base de datos.
* Al configurar estos parámetros, se hará un conteo desde la fecha en que se modificó el registro para ejecutar 
* los scripts correspondientes los cuales son:
*  - Eliminación de registros: con el propósito de optimizar la base de datos, se eliminarán registros del sistema cuya fecha
*    sea anterior a la asignada por la configuracion
*  - Respaldo de la Base de datos: se ejecutará en la fecha correspondiente a la que se calcule por la cantidad de días,
*    basados en la última que se ejecuto el script.
* 
* @version 1.0: Se ha creado el script para la generación de respaldos de la BD. En proceso el de los registros 
* @param integer $dr: cantidad de dias desde la fecha inicial para 
* @param integer $dbd: cantidad de días entre respaldos. Si se ingresa cero, el sistema lo tomará como si fuera 1 día
* 
**/

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

$dr = (isset($_POST['dr'])) ? mysqli_real_escape_string($conn, $_POST['dr']) : 0;
$dbd = mysqli_real_escape_string($conn, $_POST['dbd']);

$update .= "update configuracion set valor = ".$dr." where idconfig = 8;";

if ($dbd == 0) {
	# Si es 0, el valor será por defecto 1;
	$update .= "update configuracion set valor = 1 where idconfig = 9;";
} else {
	#Se pasa el valor de la variable
	$update .= "update configuracion set valor = ".$dbd." where idconfig = 9;";
}

$sql = mysqli_multi_query($conn, $update);

if ($sql) {
	
	//Se calcula la nueva fecha	
	$fecha = configRespaldo($dbd);


	if ($fecha == 1) {
		# Si el valor es verdadero, se envia mensaje de OK	
		echo "1";

		$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/dataconfig.php', 'update', ".time().");";
		mysqli_query($conn, $log);
	} else {
		
		echo "0";

		$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/dataconfig.php', 'error updating', ".time().");";
		mysqli_query($conn, $log);
	}	
	
} else {
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/dataconfig.php', 'error updating', ".time().");";
	mysqli_query($conn, $log);
}

mysqli_close($conn);
?>