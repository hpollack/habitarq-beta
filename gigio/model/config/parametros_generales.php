<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$idEdadVaron = mysqli_real_escape_string($conn, $_POST['idvr']);
$EdadVaron = mysqli_real_escape_string($conn, $_POST['vr']);
$idEdadMujer = mysqli_real_escape_string($conn, $_POST['idmj']);
$EdadMujer = mysqli_real_escape_string($conn, $_POST['mj']);

$idUFAmp = mysqli_real_escape_string($conn, $_POST['idamp']);
$UFAmp = mysqli_real_escape_string($conn, $_POST['amp']);
$idUFMej = mysqli_real_escape_string($conn, $_POST['idmej']);
$UFMej = mysqli_real_escape_string($conn, $_POST['mej']);

$idUFTer = mysqli_real_escape_string($conn, $_POST['idter']);
$UFTer  = mysqli_real_escape_string($conn, $_POST['ter']);
$idUFSol = mysqli_real_escape_string($conn, $_POST['idsol']);
$UFSol = mysqli_real_escape_string($conn, $_POST['sol']);

$idUFFoc = mysqli_real_escape_string($conn, $_POST['idfoc']);
$UFFoc  = mysqli_real_escape_string($conn, $_POST['foc']);

$string  = "update configuracion set valor =".$EdadVaron." where idconfig =".$idEdadVaron.";";
$string .= "update configuracion set valor =".$EdadMujer." where idconfig =".$idEdadMujer.";";
$string .= "update configuracion set valor =".$UFAmp." where idconfig =".$idUFAmp.";";
$string .= "update configuracion set valor =".$UFMej." where idconfig =".$idUFMej.";";
$string .= "update configuracion set valor =".$UFTer." where idconfig =".$idUFTer.";";
$string .= "update configuracion set valor =".$UFSol." where idconfig =".$idUFSol.";";
$string .= "update configuracion set valor =".$UFFoc." where idconfig =".$idUFFoc.";";

$sql = mysqli_multi_query($conn, $string);

if ($sql) {
	echo "1";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/parametros_generales.php', 'update', ".time().");";
	mysqli_query($conn, $log); 
}else {
	echo "0";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/config/parametros_generales.php', 'error update', ".time().");";
	mysqli_query($conn, $log); 
}

mysqli_close($conn);

?>