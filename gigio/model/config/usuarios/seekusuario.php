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

$user = mysqli_real_escape_string($conn, $_POST['us']);

if ($user == "") {
	echo "2";
	exit();
}

$string = "select idusuario, nombre, apellidos, correo, perfil, estado from usuarios where idusuario = '".$user."'";

$sql = mysqli_query($conn, $string);

if ($f = mysqli_fetch_array($sql)) {	
	$us  = $f[0];
	$nom = $f[1];
	$ap  = $f[2];
	$ml  = $f[3];
	$pfl = $f[4];
	$est = $f[5];
}else {
	$us  = null;
	$nom = null;
	$ap  = null;
	$ml  = null;
	$pfl = null;
	$est = null;
}

if ($sql) {
	$datos = array(
		'us' => $us ,
		'nom' => $nom,
		'ap' => $ap,
		'mail' => $ml,
		'pfl' => $pfl,
		'est' => $est
	 );

	echo json_encode($datos);
}else {
	echo "Error";
	exit();
}

?>