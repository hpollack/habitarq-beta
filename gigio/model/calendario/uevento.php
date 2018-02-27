<?php 

session_start();
date_default_timezone_set("America/Santiago");
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

$id  = $_POST['id'];
$fev = mysqli_real_escape_string($conn, $_POST['fev']);
$hev = mysqli_real_escape_string($conn, $_POST['hev']);
$ffv = mysqli_real_escape_string($conn, $_POST['ffv']);
$hfv = mysqli_real_escape_string($conn, $_POST['hfv']);
$tev = mysqli_real_escape_string($conn, $_POST['tev']);
$cev = mysqli_real_escape_string($conn, $_POST['cev']);

//Fecha inicio
$inicio = strtotime(fechamy($fev)." ".$hev);

//Fecha Final
$final = strtotime(fechamy($ffv)." ".$hfv);

if ($inicio > $final) {
	#Devuelve Mensaje de error 

	//echo $inicio." > ".$final;
	echo "2";
	exit();
}


$string = "update eventos_calendario set titulo = '".$tev."', inicio = ".$inicio.", final = ".$final.", ".
		  "contenido = '".$cev."' where idevento = ".$id.""; 

$sql = mysqli_query($conn, $string);

if ($sql) {
	
	# Devuelve mensaje de OK
	echo "1";


	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	       "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/calendario/index.php', 'update evento', ".time().");";

	mysqli_query($conn, $log);
}else{
	
	# Devuelve mensaje de error
	echo "0";


	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	       "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/calendario/index.php', 'error update', ".time().");";

	mysqli_query($conn, $log);

	exit();
}

mysqli_close($conn);	  


?>