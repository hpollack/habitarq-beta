<?php 
session_start();
include_once '../../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$us  = mysqli_real_escape_string($conn, $_POST['us']);
$nom = mysqli_real_escape_string($conn, $_POST['nom']);
$ap  = mysqli_real_escape_string($conn, $_POST['ap']);
$ml  = mysqli_real_escape_string($conn, $_POST['mail']);
$clv = mysqli_real_escape_string($conn, $_POST['clv']);
$pfl = $_POST['pfl'];
$est = (isset($_POST['est'])) ? 1 : 0;

if ($clv != "") {
	$clave = "clave = '".md5($clv)."',";
}else {
	$clave = "";
}

$string = "update usuarios set nombre = '".$nom."', apellidos = '".$ap."', ".
		  "correo = '".$ml."', $clave perfil = ".$pfl.", estado = ".$est." where  idusuario = '".$us."'";

$sql = mysqli_query($conn, $string);


if ($sql) {
	echo "1";
}else {
	echo "0";
}

mysqli_close($conn);
?>