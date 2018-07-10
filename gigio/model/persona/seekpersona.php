<?php
/**
 * =================================================================
 *   BUSQUEDA DE DATOS PERSONA
 * =================================================================
 * 
 * Archivo que interactua con la base de datos y extrae los datos mediante el parámetro enviado
 * desde la vista. Devuelve u objeto JSON, con los valores correspondientes o null, si no existen.
 * Estos son interpretados y parseados por el controlador Javascript persona.js
 * 
 * @param string $seek: obtiene los datos del campo de la vista. Los valores del rut.
 * @return objeto json con los datos en forma clave valor.
 * 
 **/
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();
$seek = mysqli_real_escape_string($conn, $_POST['s']);

$string = "select
	p.rut, p.dv, p.nombres, p.paterno, p.materno, p.sexo, p.correo, p.estado, d.calle,
	d.numero, c.COMUNA_ID, pr.PROVINCIA_ID, r.REGION_ID, 
	f.numero as fono, tf.idtipo, d.localidad 
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
	$sx  = $fila['sexo'];
	$mail = $fila['correo'];
	$vp = $fila['estado'];
	$dir = $fila['calle'];
	$nd =  $fila['numero'];
	$cm = $fila['COMUNA_ID'];
	$pr = $fila['PROVINCIA_ID'];
	$reg = $fila['REGION_ID'];
	$tf = $fila['fono'];
	$tp = $fila['idtipo'];
	$loc = $fila['localidad'];
}else{
	#Trae los datos de la tabla persona
	$seekpersona = "select * from persona where rut = '".$seek."'";
	$sqlp = mysqli_query($conn, $seekpersona);

	if ($sqlp) {
		
		$p = mysqli_fetch_row($sqlp);
		$rut = $p[0];
		$dv = $p[1];
		$nom = $p[2];
		$pat = $p[3];
		$mat = $p[4];
		$mail = $p[6];
		$sx  = $p[5];
		$vp = $p[7];
	}else {
		$rut = null;
		$dv = null;
		$nom = null;
		$pat = null;
		$mat = null;
		$mail = null;
		$sx  = null;
		$vp = null;
	}

	$dir = null;
	$nd = null;
	$cm = null;
	$pr = null;
	$reg = null;
	$tf = null;
	$tp = null;
	$loc = null;
}

if($sql){
	$datos = array(
		'rut' => $rut, 'dv' => $dv, 'nom' => $nom, 'ap' => $pat, 'am' => $mat,
		'sx'=> $sx, 'mail' => $mail, 'vp' => $vp, 'dir' => $dir, 
		'nd' => $nd, 'reg' => $reg, 'pr' => $pr, 
		'cm' => $cm, 'tf' => $tf, 'tp' => $tp, 'loc' => $loc
	);
	echo json_encode($datos);
}else{
	echo "Error";
	exit;
}

mysqli_free_result($sql);
mysqli_close($conn);

?>