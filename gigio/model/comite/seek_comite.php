<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$numero = mysqli_real_escape_string($_POST['num']);

$conn = conectar();
$numer = mysqli_query($conn, "select * from grupo where numero = ".$num."");

$string = "select `g`.`idgrupo`, g.numero, `g`.`fecha`, `g`.`nombre`, `g`.`personalidad`,
  `g`.`direccion`, `g`.`idcomuna`, `p`.`PROVINCIA_ID`, `r`.`REGION_ID`,
  `g`.`ds10`, `g`.`idegis`
FROM
  `grupo` `g`
  INNER JOIN `comuna` `c` ON (`g`.`idcomuna` = `c`.`COMUNA_ID`)
  INNER JOIN `provincia` `p` ON (`c`.`COMUNA_PROVINCIA_ID` = `p`.`PROVINCIA_ID`)
  INNER JOIN `region` `r` ON (`p`.`PROVINCIA_REGION_ID` = `r`.`REGION_ID`)
WHERE
  `g`.`numero` = ".$num."";

$sql = mysqli_query($conn, $string);



if($f = mysqli_fetch_array($sql)){
	$idg  = $f[0];
	$num  = $f[1];
	$fec  = fechanormal($f[2]);
	$nc   = $f[3];
	$dir  = $f[4];
	$cmn  = $f[5];
	$pr   = $f[6];
	$reg  = $f[7];
	$ds10 = $f[8];
	$egis = $f[9];
}else{
	$idg  = null;
	$num  = null;
	$fec  = null;
	$nc   = null;
	$dir  = null;
	$cmn  = null;
	$pr   = null;
	$reg  = null;
	$ds10 = null;
	$egis = null;
}

if($sql){
	$datos = array(
		'idg' => $idg,
		'num' => $num,
		'fec' => $fec,
		'nc' => $nc,
		'fec' => $fech,
		'dir' => $dir,
		'cmn' => $cmn,
		'pr'  => $pr,
		'reg' => $reg,
		'ds10' => $ds10,
		'egis' => $egis
	);
	echo json_encode($datos);
}else{
	echo "Error";
}

?>