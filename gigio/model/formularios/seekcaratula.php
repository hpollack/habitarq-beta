<?php 
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$nombre = $_SESSION['usuario'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$ruk = mysqli_real_escape_string($conn, $_POST['ruk']);
$lmd = $_POST['lmd'];
$anio = $_POST['anio'];

$datos =  "select g.nombre, g.personalidad, concat(pn.nombres,' ',pn.paterno,' ',pn.materno) AS representante, ".
		  "e.nombre AS asistente, concat(pr.nombres,' ',pr.apellidos) AS contratista, ".
		  "g.numero, concat(tt.titulo,' (',ip.item_postulacion,')') as titulo ".
		  "FROM postulaciones AS p ".
		  "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
		  "INNER JOIN profesional_postulacion AS pp ON pp.idpostulacion = p.idpostulacion ".
		  "INNER JOIN item_postulacion AS ip ON p.item_postulacion = ip.iditem_postulacion ".
		  "INNER JOIN tipopostulacion AS tp ON ip.idtipopostulacion = tp.idtipopostulacion ".
		  "INNER JOIN llamado_postulacion AS lp ON lp.idpostulacion = p.idpostulacion ".
		  "INNER JOIN persona_comite AS pc ON pc.idgrupo = g.idgrupo ".
		  "INNER JOIN persona AS pn ON pc.rutpersona = pn.rut ".
		  "INNER JOIN egis AS e ON g.idegis = e.idegis ".
		  "INNER JOIN profesionales AS pr ON pp.rutprof = pr.rutprof ".
		  "INNER JOIN titulo_postulacion tt on tt.idtitulo_postulacion = tp.idtipopostulacion ".
		  "WHERE g.numero = ".$ruk." AND pc.idcargo = 2 AND lp.idllamado = ".$lmd." and lp.anio =".$anio.""; 
//echo $datos; exit();

$postulantes = "select count(*) as postulantes ".
               "FROM lista_postulantes AS pl ".
               "INNER JOIN llamado_postulacion AS lp ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
               "INNER JOIN postulaciones AS p ON lp.idpostulacion = p.idpostulacion ".
               "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
               "WHERE g.numero = ".$ruk." and lp.idllamado = ".$lmd." and lp.anio =".$anio."";
//echo $postulantes; exit();               
 
$totaluf =   "select sum(total) as totaluf ".
			 "FROM lista_postulantes AS lp ".
			 "INNER JOIN cuenta_persona AS cp ON lp.rutpostulante = cp.rut_titular ".
			 "INNER JOIN cuenta AS c ON cp.ncuenta = c.ncuenta ".
			 "INNER JOIN llamado_postulacion AS pl ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
			 "INNER JOIN postulaciones AS p ON pl.idpostulacion = p.idpostulacion ".
			 "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
			 "where g.numero = ".$ruk." and pl.idllamado = ".$lmd." and pl.anio =".$anio."";
//echo $totaluf; exit();

$sqlDatos = mysqli_query($conn, $datos);
$p = mysqli_fetch_row(mysqli_query($conn, $postulantes));
$uf = mysqli_fetch_row(mysqli_query($conn, $totaluf));

if ($f = mysqli_fetch_array($sqlDatos)) {

	$nom = $f[0];
	$pj  = $f[1];
	$rl  = $f[2];
	$at  = $f[3];
	$ctr = $f[4];
	$np  = $p[0];
	$tf  = ($uf[0] != null) ? $uf[0] : 0;
	$ruk = $f[5];
	$tit = $f[6];
}else {
	$nom = null;
	$pj  = null;
	$rl  = null;
	$at  = null;
	$ctr = null;
	$np  = $p[0];
	$tf  = ($uf[0] != null) ? $uf[0] : 0;
	$ruk = null;
	$tit = null;
}

if ($sqlDatos) {
	$datos = array(
		'nom' => $nom, 'pj' => $pj, 'rl' => $rl, 'at' => $at,
		'ctr' => $ctr, 'np' => $np, 'tf' => $tf, 'ruk' => $ruk,
		'tit' => $tit
	 );

	echo json_encode($datos);
}else {
	//mysqli_error($conn);
	exit();
}

mysqli_close($conn);

?>