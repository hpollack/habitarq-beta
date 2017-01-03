<?php
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
$seek = mysqli_real_escape_string($conn, $_POST['s']);

$string = "select
	p.rut, p.dv, p.nombres, p.paterno, p.materno, p.correo, p.estado, d.calle,
	d.numero, c.COMUNA_ID, pr.PROVINCIA_ID, r.REGION_ID, 
	f.numero as fono, tf.idtipo 
FROM
	persona AS p
INNER JOIN direccion AS d ON d.rutpersona = p.rut
INNER JOIN comuna AS c ON d.idcomuna = c.COMUNA_ID
INNER JOIN provincia AS pr ON c.COMUNA_PROVINCIA_ID = pr.PROVINCIA_ID
INNER JOIN region AS r ON pr.PROVINCIA_REGION_ID = r.REGION_ID
INNER JOIN fono AS f ON f.rutpersona = p.rut
INNER JOIN tipofono AS tf ON f.tipo = tf.idtipo WHERE p.rut = '".$seek."'";

$sql = mysqli_query($conn, $string);
if($fila = mysqli_fetch_assoc($sql)){
	$rut = $fila['rut'];
	$dv = $fila['dv'];
	$nom = $fila['nombres'];
	$pat = $fila['paterno'];
	$mat = $fila['materno'];	
	$mail = $fila['correo'];
	$vp = $fila['estado'];
	$dir = $fila['calle'];
	$nd =  $fila['numero'];
	$cm = $fila['COMUNA_ID'];
	$pr = $fila['PROVINCIA_ID'];
	$reg = $fila['REGION_ID'];
	$tf = $fila['fono'];
	$tp = $fila['idtipo'];
}else{	
	$rut = null;
	$dv = null;
	$nom = null;
	$pat = null;
	$mat = null;
	$mail = null;
	$vp = null;		
	$dir = null;
	$nd = null;
	$cm = null;
	$pr = null;
	$reg = null;
	$tf = null;
	$tp = null;
}

if($sql){
	$datos = array(
		'rut' => $rut, 'dv' => $dv, 'nom' => $nom, 'ap' => $pat, 'am' => $mat,
		'mail' => $mail, 'vp' => $vp, 'dir' => $dir, 
		'nd' => $nd, 'reg' => $reg, 'pr' => $pr, 
		'cm' => $cm, 'tf' => $tf, 'tp' => $tp
	);
	echo json_encode($datos);
}else{
	echo "Error";
	exit;
} 

?>