<?php
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']);

$string =  "select  `p`.`rutprof`,  `p`.`dv`,  `p`.`nombres`,  `p`.`apellidos`,
			  `p`.`direccion`, `p`.`idcomuna`, `p`.`telefono`,  `p`.`correo`,
			  `p`.`cargo`, `p`.`estado`, `c`.`COMUNA_PROVINCIA_ID`, `pr`.`PROVINCIA_REGION_ID`
			from
			  `profesionales` `p`
			  inner join `comuna` `c` ON (`p`.`idcomuna` = `c`.`COMUNA_ID`)
			  inner join `provincia` `pr` ON (`c`.`COMUNA_PROVINCIA_ID` = `pr`.`PROVINCIA_ID`)
			where
			  `rutprof` = '".$rut."'";
$sql = mysqli_query($conn, $string);

if($f = mysqli_fetch_array($sql)){
	$rut = $f[0];
	$dv  = $f[1];
	$nom = $f[2];
	$ape = $f[3];
	$dir = $f[4];
	$cm  = $f[5];
	$tel = $f[6];
	$em  = $f[7];
	$crg = $f[8];
	$est = $f[9];
	$pr  = $f[10];
	$rg  = $f[11];
}else{
	$rut = null;
	$dv  = null;
	$nom = null;
	$nom = null;
	$ape = null;
	$dir = null;
	$cm  = null;
	$tel = null;
	$em  = null;
	$crg = null;
	$est = null;
	$pr  = null;
	$rg  = null;

}

if($sql) {

	$datos = array(
		'rut' => $rut,
		'dv'  => $dv,
		'nom' => $nom,
		'ape' => $ape,
		'dir' => $dir,
		'tel' => $tel,
		'cm'  => $cm,
		'em'  => $em,
		'crg' => $crg,
		'est' => $est,
		'prv' => $pr,
		'reg' => $rg
	 );

	echo json_encode($datos);
}else{
	echo "Error";
}
?>
