<?php 

session_start();
include '../../lib/php/libphp.php';
//$rutus = '1-9';
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}


$url = url();
$conn = conectar();

$rol = $_POST['rol'];
$mts = mysqli_real_escape_string($conn, $_POST['mts']);
$psm = mysqli_real_escape_string($conn, $_POST['ps']);

//Si el Combo no tiene nada escogido
if ($psm == 0) {
	
	echo "2";
	exit();
}

$amp = mysqli_fetch_row(mysqli_query($conn, "select metros from mts where rol ='".$rol."' and idestado_vivienda = 2"));

if ($amp) {
	# code...
	$string = "update mts set metros = ".$mts.", idpiso = ".$psm." where rol = '".$rol."' and idestado_vivienda = 2";
} else {
	
	$string = "insert into mts(rol,idpiso,metros, idestado_vivienda) values('".$rol."', ".$psm.",' ".$mts."', 2)";
}

$sql = mysqli_query($conn, $string);

if ($sql) {	
	
	echo "1";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/editbulk.php', 'update vivienda data', ".time().");";
	mysqli_query($conn, $log);
}else {
	
	echo "0";
	//echo mysqli_error($conn);
	exit();
}

mysqli_close($conn);

?>