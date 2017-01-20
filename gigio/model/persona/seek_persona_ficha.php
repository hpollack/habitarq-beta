<?php
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();
$rut = mysqli_real_escape_string($conn, $_POST['r']);
$sqlr = mysqli_query($conn, "select rut, concat(nombres,' ',paterno,' ',materno) as nombre from persona where rut = '".$rut."'");
$traeRut  = mysqli_fetch_row($sqlr);
if($traeRut[0]==""){
	echo "0";
	exit();
}
$string = "select
				f.tramo, f.puntaje, f.nucleo_familiar, f.deficit, FROM_UNIXTIME(f.fecha_nacimiento),
				f.idestadocivil, f.adultomayor, f.discapacidad, pf.rutpersona,
				concat(p.nombres,' ',p.paterno,' ',p.materno) as nombre,
				f.nficha
			FROM
				frh AS f
			INNER JOIN persona_ficha AS pf ON pf.nficha = f.nficha
			INNER JOIN persona AS p ON pf.rutpersona = p.rut
			WHERE
			    pf.rutpersona =  '".$rut."' and p.estado = 1";
$sql = mysqli_query($conn, $string);
if($row = mysqli_fetch_array($sql)){
	$rut = $row[8];
	$tmo = $row[0];
	$pnt = $row[1];
	$gfm = $row[2];	
	$dh = $row[3];
	$fnac = fechanormal($row[4]);
	$ec = $row[5];
	$adm = $row[6];
	$ds = $row[7];
	$nom = $row[9];
	$fch = $row[10];
}else{
	$rut = null;
	$tmo = null;
	$pnt = null;
	$gfm = null;	
	$dh = null;
	$fnac = null;
	$ec = null;
	$adm = null;
	$ds = null;
	$nom = $traeRut[1];
	$fch = null;
}

if($sql){		
	$datos = array(
		'rut' => $rut,
		'nom' => $nom,
		'tmo' => $tmo,
		'pnt' => $pnt,
		'gfm'  => $gfm,
		'ec'  => $ec,
		'fnac'=> $fnac,		
		'dh'  => $dh,
		'adm' => $adm,
		'ds'  => $ds,
		'nom' => $nom,
		'fch' => $fch
	);	

	echo json_encode($datos);
}else{
	echo "Error";
}
mysqli_free_result($sql);
mysqli_close($conn);
?>