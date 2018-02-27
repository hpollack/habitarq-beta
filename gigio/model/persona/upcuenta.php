<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';


$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

$id  = $_POST['id'];
$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$nc  = mysqli_real_escape_string($conn, $_POST['nc']);
$fap = mysqli_real_escape_string($conn, $_POST['fap']);
$ah  = mysqli_real_escape_string($conn, $_POST['ah']);
$sb  = mysqli_real_escape_string($conn, $_POST['sb']);
$asb = mysqli_real_escape_string($conn, $_POST['asb']);

if ($nc == "") {
	# El numero de cuenta no debe ir vacío
	echo "2";
	exit();
}

//Si son distintos a Ampliación.
if ($sb == 4) {
	
	$val = traerValorConfig("UfMejoramiento");
} elseif ($sb == 5) {

	$val = traerValorConfig("UFTermico");
} elseif ($sb == 6) {

	$val = traerValorConfig("UFSolar");
} else {

	$val = ($asb != "") ? $asb : 0;
}

$td = $ah + $val;

$fecha = fechamy($fap);

$cy = $_POST['cy'];
$rutc = ($cy == 1) ? $_POST['rcye'] : $rut;

$cuenta = "update cuenta SET ncuenta = '".$nc."', ahorro = ".$ah.", subsidio = ".$val.", total = ".$td.", fecha_apertura = ".strtotime($fecha)." WHERE idcuenta = ".$id."";

$persona_cuenta = "update cuenta_persona set ncuenta = '".$nc."', rut_titularc = '".$rutc."' where rut_titular = '".$rut."'";
//echo $persona_cuenta; exit(0);
$sql = mysqli_query($conn, $cuenta);
if($sql){

	$sql2 = mysqli_query($conn, $persona_cuenta);
	echo "1";
}else{
	//echo mysqli_error($conn);
	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/cuenta.php', 'update', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);
?>