<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();


$rut = mysqli_real_escape_string($conn, $_POST['rut']);

$persona  = mysqli_query($conn, "select rut, concat(nombres,' ',paterno,' ',materno) as nombre from persona where rut = '".$rut."'");
$traeRut = mysqli_fetch_row($persona);
if(!$traeRut){
	echo "no";
	exit();
}

//Datos Persona/Ficha
$string = "select concat(p.rut,'-', p.dv) as rut, p.nombres, concat(p.paterno,' ',p.materno) AS apellidos, ".
		  "f.nficha, g.nombre, from_unixtime(f.fecha_nacimiento), f.adultomayor, f.discapacidad, ".
		  "(select ff.valor from ficha_factores ff where ff.nficha = f.nficha and ff.factor = 2) as hacinamiento, ".
		  "(select fc.adultos_mayores from focalizacion fc where fc.rutpersona = p.rut) as adulto_mayor, ".
		  "(select fc.discapacidad from focalizacion fc where fc.rutpersona = p.rut) as discapacidad, ".
		  "(select fc.hacinamiento from focalizacion fc where fc.rutpersona = p.rut) as hacinamiento, ".
		  "(select fc.acon_termico from focalizacion fc where fc.rutpersona = p.rut) as termico, ".
		  "(select fc.socavones from focalizacion fc where fc.rutpersona = p.rut) as socavones, ".
		  "(select fc.xilofagos from focalizacion fc where fc.rutpersona = p.rut) as xilofagos, ".
		  "g.idgrupo ".
		  "from persona AS p ".
		  "inner join persona_comite AS pg ON pg.rutpersona = p.rut ".
		  "inner join grupo AS g ON pg.idgrupo = g.idgrupo ".
		  "inner join persona_ficha AS pf ON pf.rutpersona = p.rut ".
		  "inner join frh AS f ON pf.nficha = f.nficha ".
		  "where p.rut = '".$rut."'";

$sql = mysqli_query($conn, $string);

if ($f = mysqli_fetch_array($sql)) {	
	$r   = $f[0];
	$nper = $f[1]." ".$f[2];	
	$fic = $f[3];
	$ng  = $f[4];

	$fecha = fechamy(fechanormal($f[5]));
	$ed  = esAdultoMayor($fecha);
	$am  = $f[6];
	$dis = $f[7];
	$hac = $f[8];
	$vam = $f[9];
	$vds = $f[10];
	$vha = $f[11];
	$vte = $f[12];
	$vso = $f[13];
	$vxi = $f[14];
	$idg = $f[15];
}else {
	$r   = null;
	$nom = null;
	$ape = null;
	$fic = null;
	$ng  = null;
	$ed  = null;
	$am  = null;
	$dis = null;
	$hac = null;
	$vam = null;
	$vds = null;
	$vha = null;
	$vte = null;
	$vso = null;
	$vxi = null;
	$idg = null;
}
$datos = array(
	'r' => $r, 'nom' => $nper, 'fic' => $fic, 'ng' => $ng,
	'ed' => $ed, 'am' => $am, 'fed' => $vam, 'dis' => $dis, 'fdis' => $vds,
	'hac' => $hac, 'fhac' => $vha, 'at' => $vte, 'soc' => $vso, 'xil' => $vxi,
	'idg' => $idg
);

if ($sql) {	
	echo json_encode($datos);
}else {
	echo "Error";
	exit();
}


 ?>