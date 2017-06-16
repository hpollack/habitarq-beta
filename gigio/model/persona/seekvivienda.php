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
$persona  = mysqli_query($conn, "select p.rut, concat(nombres,' ',paterno,' ',materno) AS nombre FROM persona AS p INNER JOIN persona_ficha AS pf ON pf.rutpersona = p.rut WHERE p.rut = '".$rut."'");
$traeRut = mysqli_fetch_row($persona);
if(!$traeRut){
	echo "0";
	exit();
}

$string = "select distinct v.rol, v.fojas, v.anio_recepcion,
	(select p1.metros from mts p1 where p1.rol = v.rol and p1.idpiso = 1 and idestado_vivienda = 1) AS p1,
	(select p2.metros from mts p2 where p2.rol = v.rol and p2.idpiso = 2 and idestado_vivienda = 1) AS p2,
	(select p3.metros from mts p3 where p3.rol = v.rol and p3.idpiso = 1 and idestado_vivienda = 2) AS p3,
	(select p4.metros from mts p4 where p4.rol = v.rol and p4.idpiso = 2 and idestado_vivienda = 2) AS p4,
	(select concat(vc.numero,',', from_unixtime(vc.fecha)) from vivienda_certificados vc where vc.rol = v.rol and vc.idcertificacion = 1) as c1,
	(select concat(vc.numero,',', from_unixtime(vc.fecha)) from vivienda_certificados vc where vc.rol = v.rol and vc.idcertificacion = 2) as c2,
	(select concat(vc.numero,',', from_unixtime(vc.fecha)) from vivienda_certificados vc where vc.rol = v.rol and vc.idcertificacion = 3) as c3,
	(select concat(vc.numero,',', from_unixtime(vc.fecha)) from vivienda_certificados vc where vc.rol = v.rol and vc.idcertificacion = 4) as c4,	
	v.anio, v.conservador, v.superficie, v.tipo, v.numero, pv.rut, pv.idpersona_vivienda
from
	vivienda AS v
inner join persona_vivienda AS pv ON pv.rol = v.rol
inner join persona AS p ON pv.rut = p.rut
inner join mts AS mv ON mv.rol = v.rol
inner join piso AS pm ON mv.idpiso = pm.idpiso
inner join conservador AS cv ON v.conservador = cv.idconservador
where
	pv.rut = '".$rut."' and p.estado = 1";

$sql = mysqli_query($conn, $string);

if($f=mysqli_fetch_array($sql)){	
	$rol = $f[0];
	$foj = $f[1];
	$ar  = $f[2];
	$p1  = $f[3];
	$p2  = $f[4];
	$p3  = $f[5];
	$p4  = $f[6];

	$tmto = (float)$p1 + (float)$p2;
	$tmta = (float)$p3 + (float)$p4;

	$c1 = explode(',', $f[7]);
	$cnum1 = $c1[0];
	$cfec1  = fechanormal($c1[1]);

	$c2 = explode(',', $f[8]);
	$cnum2 = $c2[0];
	$cfec2  = fechanormal($c2[1]);

	$c3 = explode(',', $f[9]);
	$cnum3 = $c3[0];
	$cfec3  = fechanormal($c3[1]);

	$c4 = explode(',', $f[10]);
	$cnum4 = $c4[0];
	$cfec4  = fechanormal($c4[1]);

	$an = $f[11];
	$cv = $f[12];
	$st = $f[13];
	$tv = $f[14];
	$num = $f[15];
	$nom = $traeRut[1];
	$idr = $f[17];
}else{
	$rol = null;
	$foj = null;
	$ar  = null;
	$p1  = null;
	$p2  = null;
	$p3  = null;
	$p4  = null;
	$cnum1  = null;
	$cfec1  = null;
	$cnum2  = null;
	$cfec3  = null;
	$cnum3  = null;
	$cfec3  = null;
	$cnum4  = null;
	$cfec4  = null;
	$tmto = null;
	$tmta = null;
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
		'mp3' => $p3,
		'mp4' => $p4,
		'tmso' => $tmto,
		'tmsa' => $tmta,
		'npe'  => $cnum1,
		'numpe' => $cfec1,
		'ncr' => $cnum2,
		'numcr' => $cfec2,
		'nrg' => $cnum3,
		'numrg' => $cfec3,
		'nip' => $cnum4,
		'numip' =>$cfec4,
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

mysqli_free_result($sql);
mysqli_close($conn);
?>