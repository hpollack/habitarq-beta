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
$cm  = mysqli_real_escape_string($conn, $_POST['cm']);
$egs = mysqli_real_escape_string($conn, $_POST['egis']);

//Se evalua si el nombre individual en sus distintas facetas, existe.
$nombre = mysqli_query($conn, "select nombre from grupo where nombre = '".$nc."'");
$nomexist = mysqli_fetch_row($nombre);
if(($nomexist[0] == "Individual") || ($nomexist[0] == "individual") || ($nomexist[0] == "INDIVIDUAL")){
	echo "2";
	exit();
}

$string = "insert into grupo (numero, fecha, personalidad, nombre, direccion, idcomuna, idegis)".
	      " values(".$num.", ".strtotime(fechamy($fec)).", '".$per."', '".$nc."', '".$dir."', ".$cm.", ".$egs.")";

$sql = mysqli_query($conn, $string);

if($sql){
	echo "1";
}else{
	echo "0";
}


?>