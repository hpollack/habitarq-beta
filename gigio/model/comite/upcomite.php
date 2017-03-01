<?php
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$conn = conectar();

$idg = $_POST['idg'];
$num = mysqli_real_escape_string($conn, $_POST['num']);
$fec = mysqli_real_escape_string($conn, $_POST['fec']);
$per = $num.",".fechamy($fec);
$nc  = mysqli_real_escape_string($conn, $_POST['nc']);
$dir = mysqli_real_escape_string($conn, $_POST['dir']);
$cm  = mysqli_real_escape_string($conn, $_POST['cm']);
$egs = mysqli_real_escape_string($conn, $_POST['egis']);

$nombre = mysqli_query($conn, "select nombre from grupo where nombre = '".$nc."'");
$nomexist = mysqli_fetch_row($nombre);
if(($nomexist[0] == "Individual") || ($nomexist[0] == "individual") || ($nomexist[0] == "INDIVIDUAL")){
	echo "2";
	exit();
}

$string = "update grupo SET numero = ".$num.", fecha = ".strtotime(fechamy($fec)).", personalidad = '".$per."', ".
"nombre = '".$nc."', direccion = '".$dir."', idcomuna = ".$cm.", idegis = ".$egs." WHERE idgrupo = ".$idg."";

$sql = mysqli_query($conn, $string);

if($sql){	
	echo "1";
}else{
	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'update', ".time().");";

mysqli_query($conn, $log);
mysqli_close($conn);

?>