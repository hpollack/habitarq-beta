<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$conn = conectar();

$num = mysqli_real_escape_string($conn, $_POST['num']);

$sqlGrupo = mysqli_query($conn, "select idgrupo, nombre from grupo where numero = ".$num."");
$traeGrupo = mysqli_fetch_row($sqlGrupo);


if ($traeGrupo[0]=="") {
	echo "0";
	exit();
}




$str = "select p.idpostulacion, p.idgrupo, p.item_postulacion, from_unixtime(p.fecha_inicio), ".
	   "p.dias, pp.rutprof, g.numero, g.nombre, ".
	   "ip.idtipopostulacion, tp.idtitulo ".
	   "from postulaciones as p ".
	   "inner join grupo as g on p.idgrupo = g.idgrupo ".
	   "inner join profesional_postulacion as pp on pp.idpostulacion = p.idpostulacion ".
	   "inner join item_postulacion as ip on p.item_postulacion = ip.iditem_postulacion ".
	   "inner join tipopostulacion as tp on ip.idtipopostulacion = tp.idtipopostulacion ".
	   "where g.numero = ".$num."";

$sql = mysqli_query($conn, $str);

if(!$sql) {
	echo mysqli_error($conn);
	exit();
}


if ($f = mysqli_fetch_array($sql)) {
	
	$pos  = $f[0];
	$idg  = $f[1];
	$item = $f[2];
	$fi   = fechanormal($f[3]);
	$ds   = $f[4];
	$con  = $f[5];
	$num  = $f[6];
	$nom  = $f[7];
	$tip  = $f[8];
	$tit  = $f[9];
}else {

	$pos  = null;
	$idg  = $traeGrupo[0];
	$item = $traeGrupo[1];
	$fi   = null;
	$ds   = null;
	$con  = null;;
	$num  = null;
	$nom  = null; 
	$tip  = null;
	$tit  = null;   
}

if ($sql) {
	$datos = array(
		'pos' => $pos, 'idg' => $idg, 'item' => $item,
		'fi' => $fi, 'ds' => $ds, 'con' => $con, 'num' => $num,
		'nom' => $nom, 'tip' => $tip, 'tit' => $tit
	);

	echo json_encode($datos);
}else {
	echo "Error";
	exit();
}



mysqli_free_result($sql);
mysqli_close($conn);




?>