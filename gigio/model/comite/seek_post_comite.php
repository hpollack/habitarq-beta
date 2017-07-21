<?php 
session_start();

date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];

if(!$rutus){
    echo "No puede ver esta pagina";
    header("location: ".url()."login.php");
    exit();
}

$conn = conectar();

$num = mysqli_real_escape_string($conn, $_POST['num']);


$str = "select p.idpostulacion, g.idgrupo, p.item_postulacion, from_unixtime(p.fecha_inicio), ".
	   "p.dias, pp.rutprof, g.numero, g.nombre,  ".
	   "ip.idtipopostulacion, tp.idtitulo, max(lp.idllamado), lp.anio, from_unixtime(p.fecha_final) ".
	   "from postulaciones as p ".
	   "inner join grupo as g on p.idgrupo = g.idgrupo ".
	   "inner join profesional_postulacion as pp on pp.idpostulacion = p.idpostulacion ".
	   "inner join item_postulacion as ip on p.item_postulacion = ip.iditem_postulacion ".
	   "inner join tipopostulacion as tp on ip.idtipopostulacion = tp.idtipopostulacion ".
	   "inner join llamado_postulacion lp on lp.idpostulacion = p.idpostulacion ".
	   "where g.numero = ".$num."";	

$sql = mysqli_query($conn, $str);


if(!$sql) {
	echo "0";
	exit();
}

$string = "select idgrupo, nombre from grupo where numero = ".$num."";

$sqlGrupo = mysqli_query($conn, $string);
	
$g = mysqli_fetch_row($sqlGrupo);

$idg = $g[0];
$nom = $g[1];



if ($f = mysqli_fetch_array($sql)) {	
	$pos  = $f[0];
	//$idg  = $f[1];
	$item = $f[2];
	$fi   = fechanormal($f[3]);
	$ds   = $f[4];
	$con  = $f[5];
	$num  = $f[6];
	//$nom  = $f[7];
	$tip  = $f[8];
	$tit  = $f[9];
	$lmd  = $f[10];
	$anl  = $f[11];
	$ff   = fechanormal($f[12]);
}else {	
	
	//$idg = $g[0];
	//$nom = $g[1];
	$pos  = null;	
	$item = null;
	$fi   = null;
	$ds   = null;
	$con  = null;
	$num  = null;	
	$tip  = null;
	$tit  = null;
	$lmd  = null;
	$anl  = null;
	$ff   = null;   
}

if ($sql) {	

	$datos = array(
		'pos' => $pos, 'idg' => $idg, 'item' => $item,
		'fi' => $fi, 'ds' => $ds, 'con' => $con, 'num' => $num,
		'nom' => $nom, 'tip' => $tip, 'tit' => $tit, 
		'lmd' => $lmd, 'anl' => $anl, 'ff' => $ff
	);

	echo json_encode($datos);
}else {
	echo "Error";
	exit();
}

mysqli_close($conn);
?>