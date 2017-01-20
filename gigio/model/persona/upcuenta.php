<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();
$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$nc  = mysqli_real_escape_string($conn, $_POST['nc']);
$fap = mysqli_real_escape_string($conn, $_POST['fap']);
$ah  = mysqli_real_escape_string($conn, $_POST['ah']);
$sb  = (mysqli_real_escape_string($conn, $_POST['sb'])!="")? mysqli_real_escape_string($conn, $_POST['sb']): 0;

$td  = $ah + $sb;
$fecha = fechamy($fap);

$cuenta = "update cuenta SET ahorro = ".$ah.", subsidio = ".$sb.", total = ".$td.", fecha_apertura = ".strtotime($fecha)." WHERE ncuenta = '".$nc."'";
//echo $cuenta."<br>";
$sql = mysqli_query($conn, $cuenta);
if($sql){
	echo "Información actualizada";
}else{
	//echo mysqli_error($conn);
	echo "Error al actualizar";
	exit();
}

?>