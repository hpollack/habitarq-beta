<?php 
session_start();

date_default_timezone_set("America/Santiago");

include_once '../../lib/php/libphp.php';

set_time_limit(60);

$rutus = $_SESSION['rut'];
if(!$rutus) {
	echo "No puede ver esta página";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$rk   = $_POST['ruk'];
$lmd  = $_POST['lmd'];
$anio = $_POST['anio'];

$string = "select g.numero, g.nombre, count(lp.rutpostulante) as postulantes 
		  from persona_comite AS pc 
		  INNER JOIN persona AS p ON pc.rutpersona = p.rut 
		  INNER JOIN grupo AS g ON pc.idgrupo = g.idgrupo 
		  INNER JOIN comite_cargo AS c ON pc.idcargo = c.idcargo 
		  INNER JOIN persona_ficha AS pf ON pf.rutpersona = p.rut 
		  INNER JOIN persona_vivienda AS pv ON pv.rut = p.rut 
		  INNER JOIN cuenta_persona AS cp ON cp.rut_titular = p.rut 
		  INNER JOIN cuenta AS cn ON cn.ncuenta = cp.ncuenta 
		  INNER JOIN lista_postulantes AS lp ON lp.rutpostulante = pc.rutpersona 
		  INNER JOIN llamado_postulacion AS llp ON llp.idllamado_postulacion = lp.idllamado_postulacion 
		  INNER JOIN postulaciones AS ps ON ps.idgrupo = g.idgrupo AND llp.idpostulacion = ps.idpostulacion 
		  WHERE g.numero = ".$rk." AND p.estado = 1 AND llp.idllamado = ".$lmd." and llp.anio = ".$anio." 
		  AND pc.estado = 'Postulante'";
//echo $string; exit();

$sql = mysqli_query($conn, $string);

if ($f = mysqli_fetch_array($sql)) {
	
	$ruk = $f[0];
	$nom = $f[1];
	$pos = $f[2];
} else {

	$ruk = null;
	$nom = null;
	$pos = null;
}

if ($sql) {
	
	$datos = array('ruk' => $ruk, 'nom' => $nom, 'pos' => $pos);
	echo json_encode($datos);
} else {

	echo "Error";
	exit();
}

mysqli_close($conn);



?>