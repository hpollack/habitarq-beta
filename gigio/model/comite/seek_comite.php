<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';


$conn = conectar();

$numero = mysqli_real_escape_string($conn, $_POST['num']);


$string = "select g.idgrupo, g.numero, from_unixtime(g.fecha), g.personalidad, g.nombre,
g.direccion, g.idcomuna, p.PROVINCIA_ID, r.REGION_ID, e.idegis
FROM grupo AS g 
INNER JOIN egis AS e ON g.idegis = e.idegis
INNER JOIN comuna AS c ON g.idcomuna = c.COMUNA_ID
INNER JOIN provincia AS p ON c.COMUNA_PROVINCIA_ID = p.PROVINCIA_ID
INNER JOIN region AS r ON p.PROVINCIA_REGION_ID = r.REGION_ID
WHERE
g.numero = ".$numero."";

$sql = mysqli_query($conn, $string);



if($f = mysqli_fetch_array($sql)){
	$idg  = $f[0];
	$num  = $f[1];
	$fec  = fechanormal($f[2]);
	$per  = $f[3];
	$nom  = $f[4];
	$dir  = $f[5];
	$cmn  = $f[6];
	$prv  = $f[7];
	$reg  = $f[8];
	$egs  = $f[9];
}else{
	$idg  = null;
	$num  = null;
	$fec  = null;
	$per  = null;
	$nom  = null;
	$dir  = null;
	$cmn  = null;
	$prv  = null;
	$reg  = null;
	$egs  = null;
}

if($sql){
	$datos = array(
		'idg' => $idg,
		'num' => $num,
		'fec' => $fec,
		'nc'  => $nom,		
		'dir' => $dir,
		'nper' => $per,		
		'per' => $per,
		'cmn' => $cmn,
		'pr'  => $prv,
		'reg' => $reg,
		'egis' => $egs
	);
	echo json_encode($datos);

}else{
	echo "Error";
}

?>