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
$sqlr = mysqli_query($conn, "select rut, concat(nombres,' ',paterno,' ',materno) as nombre from persona where rut = '".$rut."'");
$traeRut  = mysqli_fetch_row($sqlr);

if($traeRut[0]==""){
	echo "0";
	exit();
}

$string = "select
				f.tramo, f.nucleo_familiar, f.deficit,f.fecha_nacimiento,
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
	$fecha = date("d/m/Y", $row[3]);

	$rut = $row[7];
	$tmo = $row[0];
	$gfm = $row[1];	
	$dh = $row[2];
	$fnac = $fecha;
	$ec = $row[4];
	$adm = $row[5];
	$ds = $row[6];
	$nom = $row[8];
	$fch = $row[9];
}else{
	$rut = null;
	$tmo = null;
	$pnt = null;		
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