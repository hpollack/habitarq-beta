<?php 
session_start();
include_once '../../../lib/php/libphp.php';
date_default_timezone_set("America/Santiago");

$conn = conectar();

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$string = "";
$iduser = $_POST['nomuser'];
$cla  = mysqli_real_escape_string($conn, $_POST['cla']);
$cln  = mysqli_real_escape_string($conn, $_POST['cln']);
$rlv  = mysqli_real_escape_string($conn, $_POST['rlv']);

$clv = mysqli_fetch_row(mysqli_query($conn, "select clave from usuarios where idusuario = '".$iduser."'"));

if (md5($cla) != $clv[0]) {
	echo "4";
	exit();
}

if (($cla == $rlv) || ($cla == $cln)) {
	echo "2";
	exit();
}else if ($cln != $rlv) {
	echo "3";
	exit();
}else {
	$string = "update usuarios set clave = md5('".$cln."') where idusuario = '".$iduser."'";	
}

$sql = mysqli_query($conn, $string);

if ($sql) {
	echo "1";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/cambiaclave.php', 'update password', ".time().");";
	mysqli_query($conn, $log);
}else {
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/cambiaclave.php', 'error update password', ".time().");";
	mysqli_query($conn, $log);
	exit();
}

mysqli_close($conn);

?>