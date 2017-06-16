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

$usuario = mysqli_fetch_row(mysqli_query($conn, "select idusuario from usuarios where idusuario = '".$us."'"));

if($usuario[0]) {
	echo "2";
	exit();
}

$user = explode('-', $us);

$dv = validaDV($user[0]);

if ($dv != $user[1]) {
	echo "3";
	exit();
}

$string = "insert into usuarios(idusuario, nombre, apellidos, correo, clave, perfil, estado) ".
		  "values('".$us."', '".$nom."', '".$ap."', '".$ml."', '".md5($clv)."', ".$pfl.", ".$est.")";


$sql = mysqli_query($conn, $string);

if ($sql) {
	echo "1";
}else {
	echo "0";
	exit();
}

mysqli_close($conn);
?>