<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$rut  = mysqli_real_escape_string($conn, $_POST['rut']);
$idg  = $_POST['idg'];

//Datos focalizaciones
$fed  = (isset($_POST['fed'])) ? 1 : 0;
$fdis = (isset($_POST['fdis'])) ? 1 : 0;
$fhac = (isset($_POST['fhac'])) ? 1 : 0 ;
$at   = (isset($_POST['at'])) ? 1 : 0;
$soc  = (isset($_POST['soc'])) ? 1 : 0;
$xil  = (isset($_POST['xil'])) ? 1 : 0;

$string = "update focalizacion set adultos_mayores = ".$fed.", discapacidad = ".$fdis.", hacinamiento = ".$fhac.", ".
		  "acon_termico = ".$at.", socavones = ".$soc.", xilofagos = ".$xil." ".
		  "where rutpersona = '".$rut."'";

$sql = mysqli_query($conn, $string);

if ($sql) {
	echo "1";
	
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."/view/persona/focalizacion.php', 'update', ".time().");";
	
	mysqli_query($conn, $log);
}else {
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."/view/persona/focalizacion.php', 'error update', ".time().");";
	
	mysqli_query($conn, $log);
	exit();
}

mysqli_close($conn);
?>