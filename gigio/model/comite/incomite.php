<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$conn = conectar();

$num = mysqli_real_escape_string($conn, $_POST['num']);
$fec = mysqli_real_escape_string($conn, $_POST['fec']);
$per = $num.",".fechamy($fec);
$nc  = mysqli_real_escape_string($conn, $_POST['nc']);
$dir = mysqli_real_escape_string($conn, $_POST['dir']);
$pr  = mysqli_real_escape_string($conn, $_POST['pr']);
$cm  = mysqli_real_escape_string($conn, $_POST['cm']);

$string = "insert into grupo (numero, fecha, personalidad, nombre, direccion, idcomuna)".
	      " values(".$num.", ".strtotime(fechamy($fec)).", '".$per."', '".$nc."', '".$dir."', ".$cm.")";

$sql = mysqli_query($conn, $string);

if($sql){
	echo "1";
}else{
	echo "0";
}


?>