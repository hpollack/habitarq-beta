<?php
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
$rut = mysqli_real_escape_string($conn, $_POST['r']);
$persona  = mysqli_query($conn, "select rut, concat(nombres,' ',paterno,' ',materno) as nombre from persona where rut = '".$rut."'");
$traeRut = mysqli_fetch_row($persona);
if(!$traeRut){
	echo "0";
	exit();
}

$string = "select distinct v.rol, v.fojas, v.anio_recepcion,
	(select p1.metros from mts p1 where p1.rol = v.rol and p1.idpiso = 1) as p1,
	(select p2.metros from mts p2 where p2.rol = v.rol and p2.idpiso = 2) as p2,
	v.anio, v.conservador, v.superficie, v.tipo, v.numero, pv.rut, pv.idpersona_vivienda
from
	vivienda AS v
inner join persona_vivienda AS pv ON pv.rol = v.rol
inner join persona AS p ON pv.rut = p.rut
inner join mts AS mv ON mv.rol = v.rol
inner join piso AS pm ON mv.idpiso = pm.idpiso
inner join conservador AS cv ON v.conservador = cv.idconservador
where
	pv.rut = '".$rut."'";

$sql = mysqli_query($conn, $string);
if($f=mysqli_fetch_array($sql)){	
	$rol = $f[0];
	$foj = $f[1];
	$ar  = $f[2];
	$p1  = $f[3];
	if($f[4]!=0){
		$p2  = $f[4];
		$tmt = (float)$p1+(float)$p2;
	}else{
		$p2 = "0";
		$tmt = $p1;
	}
	
	$an  = $f[5];
	$cv  = $f[6];
	$st  = $f[7];
	$tv  = $f[8];
	$num = $f[9];
	$nom = $traeRut[1];
	$idr = $f[11];
}else{
	$rol = null;
	$foj = null;
	$ar  = null;
	$p1  = null;
	$p2  = null;
	$tmt = null;
	$an  = null;
	$cv  = null;
	$st  = null;
	$tv  = null;
	$num = null;
	$nom = $traeRut[1];
	$idr = null;
}

if($sql){
	$datos = array(
		'rol' => $rol,
		'foj' => $foj,
		'ar'  => $ar,
		'mp1' => $p1,
		'mp2' => $p2,
		'tms' => $tmt,
		'ac'  => $an,
		'cv'  => $cv,
		'st'  => $st,
		'tv'  => $tv,
		'num' => $num,
		'nom' => $nom,
		'idr' => $idr
	 );
	echo json_encode($datos);
}else{
	echo "Error";
}
?>