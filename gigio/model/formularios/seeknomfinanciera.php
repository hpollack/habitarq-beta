<?php 
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

$ruk = mysqli_real_escape_string($conn, $_POST['ruk']);
$lmd = $_POST['lmd'];
$anio = $_POST['anio'];

$string = "select g.numero, g.nombre, count(lp.rutpostulante) as postulantes, ".
		  "sum(cn.total) as totaluf ".	
		  "from persona_comite AS pc ".
		  "INNER JOIN persona AS p ON pc.rutpersona = p.rut ".
		  "INNER JOIN grupo AS g ON pc.idgrupo = g.idgrupo ".
		  "INNER JOIN comite_cargo AS c ON pc.idcargo = c.idcargo ".
		  "INNER JOIN persona_ficha AS pf ON pf.rutpersona = p.rut ".
		  "INNER JOIN persona_vivienda AS pv ON pv.rut = p.rut ".
		  "INNER JOIN cuenta_persona AS cp ON cp.rut_titular = p.rut ".
		  "INNER JOIN cuenta AS cn ON cn.ncuenta = cp.ncuenta ".
		  "INNER JOIN lista_postulantes AS lp ON lp.rutpostulante = pc.rutpersona ".
		  "INNER JOIN llamado_postulacion AS llp ON llp.idllamado_postulacion = lp.idllamado_postulacion ".
		  "INNER JOIN postulaciones AS ps ON ps.idgrupo = g.idgrupo AND llp.idpostulacion = ps.idpostulacion ".
		  "WHERE g.numero = ".$ruk." AND p.estado = 1 AND llp.idllamado = ".$lmd." and llp.anio = ".$anio." ".
		  "AND pc.estado = 'Postulante'";		  

$sql = mysqli_query($conn, $string);

if ($f = mysqli_fetch_array($sql)) {
	$gruk = $f[0];
	$gnom = $f[1];
	$gpos = $f[2];
	$guf  = ($f[3] != null)? $f[3] : 0;
}else {
	$gruk = null;
	$gnom = null;
	$gpos = null;
	$guf  = null;
}

if ($sql) {
	$datos = array('gruk' => $gruk, 'gnom' => $gnom, 'gpos' => $gpos, 'guf' => $guf);

	echo json_encode($datos);
}else {
	echo "Error";
	exit();
}

?>