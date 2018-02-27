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
$rut = mysqli_real_escape_string($conn, $_POST['r']);
$persona  = mysqli_query($conn, "select rut, concat(nombres,' ',paterno,' ',materno) as nombre from persona where rut = '".$rut."'");
$traeRut = mysqli_fetch_row($persona);

$uf = traeUF();

$cye = 0;

if(!$traeRut){
	echo "0";
	exit();
}

//Si existe un conyuge trae el valor del id
$conyuge = mysqli_fetch_row(mysqli_query($conn, "select rutconyuge, concat(nombres,' ', paterno,' ', materno) from conyuge where rutpersona = '".$rut."'"));

if ($conyuge) {
	# code...
	$rcye = $conyuge[0];
	$ncye = $conyuge[1];
	$cye  = 1;
}

$mj = traerValorConfig("UFMejoramiento");
$tm = traerValorConfig("UFTermico");
$sl = traerValorConfig("UFSolar");

$string = "select c.ncuenta, from_unixtime(c.fecha_apertura), c.ahorro, c.subsidio, c.total, cp.rut_titular, c.idcuenta
FROM 	cuenta AS c
INNER JOIN cuenta_persona AS cp ON cp.ncuenta = c.ncuenta
INNER JOIN persona AS p ON cp.rut_titular = p.rut
WHERE cp.rut_titular = '".$rut."' and p.estado = 1";

$sql = mysqli_query($conn, $string);

if($f = mysqli_fetch_array($sql)){
	$nc  = $f[0];
	$fap = fechanormal($f[1]);
	$ah  = $f[2];
	//$sb  = $f[3];
	if ($f[3] == $mj) {
		# ID Mejoramiento
		$sb = 4;
	} elseif ($f[3] == $tm) {
		# Id Termico
		$sb = 5;
	} elseif ($f[3] == $sl) {
		# Id Solar
		$sb = 6;
	} else {
		$sb  = 3;
	}
	$asb = ($f[3] != null) ? $f[3] : 0;
	$td  = $f[4];
	$tp  = ($f[4] * $uf);
	$nom = $traeRut[1];
	$con = $rcye;
	$ncon = $ncye;
	$vcon = $cye;
	$id   = $f[6];

}else{
	$nc  = null;
	$fap = null;
	$ah  = null;
	$sb  = null;
	$asb = null;
	$td  = null;
	$tp  = null;
	$nom = $traeRut[1];
	$con = $rcye;
	$ncon = $ncye;
	$id   = null;
}
if($sql){
	$datos = array(
		'nc'  => $nc,
		'fap' => $fap,
		'ah'  => $ah,
		'sb'  => $sb,
		'asb' => $asb,
		'td'  => $td,
		'vtd' => $td,
		'tp'  => number_format($tp, 0, ",", "."),
		'nom' => $nom,
		'con' => $con,
		'ncon' => $ncon,
		'cye' => $cye,
		'id'  => $id
	 );
	echo json_encode($datos);
}else{
	echo "Error";
	exit();
}

mysqli_free_result($sql);
mysqli_close($conn);

?>