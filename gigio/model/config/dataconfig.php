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