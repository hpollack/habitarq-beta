<?php 
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

$rut  = mysqli_real_escape_string($conn, $_POST['rut']);
$idg  = $_POST['idg'];

//Datos focalizaciones
//Datos focalizaciones
$fed  = (isset($_POST['fed'])) ? 1 : 0;
$fdis = (isset($_POST['fdis'])) ? 1 : 0;
$fhac = (isset($_POST['fhac'])) ? 1 : 0 ;
$at   = (isset($_POST['at'])) ? 1 : 0;
$soc  = (isset($_POST['soc'])) ? 1 : 0;
$xil  = (isset($_POST['xil'])) ? 1 : 0;
$sst  = (isset($_POST['sst'])) ? 1 : 0;
$ses  = (isset($_POST['ses'])) ? 1 : 0;
$elc  = (isset($_POST['elc'])) ? 1 : 0;
$san  = (isset($_POST['san'])) ? 1 : 0;
$alc  = (isset($_POST['alc'])) ? 1 : 0;
$mts  = (isset($_POST['fmts'])) ? 1 : 0;




$string = "update focalizacion set adultos_mayores = ".$fed.", discapacidad = ".$fdis.", hacinamiento = ".$fhac.", ".
		  "acon_termico = ".$at.", socavones = ".$soc.", xilofagos = ".$xil.", sis_term = ".$sst.", seg_estruct = ".$ses.", ".
		  "basic_elect = ".$elc.", basic_sanit = ".$san.", basic_alcan = ".$alc.", mts_original = ".$mts." ".
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