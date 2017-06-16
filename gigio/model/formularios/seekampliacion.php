<?php 
session_start();
include_once '../../lib/php/libphp.php';
$rutus = $_SESSION['rut'];

if (!$rutus) {
	echo "No puede ver esta página";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$ruk = mysqli_real_escape_string($conn, $_POST['cmt']);
$lmd = $_POST['lmd'];
$anio = $_POST['anio'];

$string = "select g.nombre, count(pl.rutpostulante) as postulantes ".
		  "FROM lista_postulantes AS pl ".
		  "INNER JOIN llamado_postulacion AS lp ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
		  "INNER JOIN postulaciones AS p ON lp.idpostulacion = p.idpostulacion ".
		  "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
		  "inner join persona_vivienda as pv on pv.rut = pl.rutpostulante ".
		  "inner join vivienda as v on v.rol = pv.rol ".
		  "WHERE g.numero = ".$ruk." and lp.idllamado = ".$lmd."  and lp.anio = ".$anio." ".
		  "group by g.nombre";	

$sql = mysqli_query($conn, $string);

if ($f = mysqli_fetch_array($sql)) {
	# code...
	$cmt = $f[0];
	$num = $f[1];
}else {
	$cmt = null;
	$num = null;
}

if ($sql) {	
	$datos = array('cmt' => $cmt, 'nm' => $num);
	echo json_encode($datos);
}else {
	echo "Error";
	exit();
}

?>