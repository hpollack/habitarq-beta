<?php 
session_start();
include_once '../../lib/php/libphp.php';

$url = url();
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".$url."login.php");
	exit();
}

$conn = conectar();
$rut = $_POST['rutp'];
if (!isset($rut)) {
	
	//$string = "update conyuge set estado = 0 where rutpersona = '".$rut."'";
	echo "0";
	exit();
}

$string = "update conyuge set estado = 0 where rutpersona = '".$rut."'";
$sql = mysqli_query($conn, $string);

if ($sql) {
	
	$sql2 = mysqli_query($conn,"select nficha from persona_ficha where rutpersona = '".$rut."'");
	if ($sql2) {
		$f = mysqli_fetch_row($sql2);
		mysqli_query($conn, "update frh set idestadocivil = 0 where nficha = ".$f[0]."");
	} else {
		echo mysqli_error($conn);
		exit();
	}

	echo "1";
	insLog($rutus,$url."view/persona/ficha.php","del");
} else {

	echo "0";
	insLog($rutus,$url."view/persona/ficha.php"," error del");

}

mysqli_close($conn);

?>