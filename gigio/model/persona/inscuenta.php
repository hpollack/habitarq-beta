<?php
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$nc  = mysqli_real_escape_string($conn, $_POST['nc']);
$fap = mysqli_real_escape_string($conn, $_POST['fap']);
$ah  = mysqli_real_escape_string($conn, $_POST['ah']);
$sb  = mysqli_real_escape_string($conn, $_POST['sb']);
$td  = $ah + $sb;
$fecha = fechamy($fap);

$cuenta = "insert into cuenta (ncuenta, ahorro, subsidio, total, fecha_apertura) values ('".$nc."', ".$ah.", ".$sb.", ".$td.", ".strtotime($fecha).")";
$persona_cuenta = "insert into cuenta_persona(rut_titular, ncuenta) values('".$rut."','".$nc."')";

$sql1 = mysqli_query($conn, $cuenta);
if($sql1){
	$sql2 = mysqli_query($conn,$persona_cuenta);
	echo "Datos almacenados";
}else{
	echo "Ocurrio un error al conectar a la base de datos";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/cuenta.php', 'add', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);

?>