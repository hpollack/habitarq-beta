<?php
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
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

?>