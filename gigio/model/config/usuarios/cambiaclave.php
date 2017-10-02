<?php 

//Proceso en servidor para cambiar la clave de usuario. (todos);


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

//Variables: nombre de usuario (rut), clave antigua y clave nueva (2 veces);
$string = "";
$iduser = $_POST['nomuser'];
$cla  = mysqli_real_escape_string($conn, $_POST['cla']);
$cln  = mysqli_real_escape_string($conn, $_POST['cln']);
$rlv  = mysqli_real_escape_string($conn, $_POST['rlv']);

$clv = mysqli_fetch_row(mysqli_query($conn, "select clave from usuarios where idusuario = '".$iduser."'"));

//Si la clave antigua no coincide, envpia mensaje
if (md5($cla) != $clv[0]) {

	echo "4";
	exit();
}

//La clave  nueva se ingresa dos veces
if (($cla == $rlv) || ($cla == $cln)) {

	#Si la clave nueva es la misma que la anterior, envía mensaje de error (sea cual sea el campo)
	echo "2";
	exit();
}else if ($cln != $rlv) {
	
	#Los datos en el campo de clave nueva y de repetir deben ser idénticos. De no serlo envía mensaje de error
	echo "3";
	exit();
}else {

	#Si están correctos toos los parámetros.
	$string = "update usuarios set clave = md5('".$cln."') where idusuario = '".$iduser."'";	
}

//ejecuta si esta correcto todo, la actualización de la clave
$sql = mysqli_query($conn, $string);

if ($sql) {

	#Envía mensaje positivo si la ejecución en la base de datos salió bien
	echo "1";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/cambiaclave.php', 'update password', ".time().");";
	mysqli_query($conn, $log);
}else {

	#Mensaje de error en caso de no ejecutarse.
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/cambiaclave.php', 'error update password', ".time().");";
	mysqli_query($conn, $log);
	exit();
}

mysqli_close($conn);

?>