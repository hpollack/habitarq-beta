<?php 
/**
 * =========================================================================
 *  INGRESO DE FOCALIZACIONES
 * =========================================================================
 * 
 * Script de igreso de las focalizaciones. Todos los parámetros son 1 o 0, 
 * dependiendo de si vienen checkeados o no.
 * 
 * @author Hermann Pollack
 * @version 1.0
 * 
**/
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

$string = "insert into focalizacion(idfocalizacion, rutpersona, idgrupo, adultos_mayores, ".
		  "discapacidad, hacinamiento, acon_termico, socavones, xilofagos, sis_term, seg_estruct, basic_elect, basic_sanit, basic_alcan, mts_original) ".
		  "values(".obtenerid("focalizacion", "idfocalizacion").", '".$rut."', ".$idg.", ".$fed.", ".$fdis.", ".$fhac.", ".$at.", ".$soc.", ".$xil.", ".$sst.", ".$ses.", ".$elc.", ".$san.", ".$alc.", ".$mts.")";

//echo $string; exit();

$sql = mysqli_query($conn, $string);

if ($sql) {
	
	echo "1";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."/view/persona/focalizacion.php', 'add', ".time().");";

	mysqli_query($conn, $log);
}else {
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."/view/persona/persona.php', 'error add', ".time().");";

	mysqli_query($conn, $log);
	exit();
}

mysqli_close($conn);

?>