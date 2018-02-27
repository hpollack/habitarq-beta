<?php 
session_start();
include_once '../../lib/php/libphp.php';

date_default_timezone_set("America/Santiago");
set_time_limit(60);

$rutus = $_SESSION['rut'];
if(!$rutus) {
	echo "No puede ver esta página";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$ruk = mysqli_real_escape_string($conn, $_POST['ruk1']);
$lmd = $_POST['llmd'];
$anio = $_POST['ganio'];

//echo $ruk; exit();

$datosGrupo = "select g.nombre, g.numero, c.COMUNA_NOMBRE, r.REGION_ID from grupo as g ".
			  "inner join comuna as c on c.COMUNA_ID = g.idcomuna ".
			  "inner join provincia as p on p.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
			  "inner join region as r on r.REGION_ID = p.PROVINCIA_REGION_ID ".
			  "where g.numero = ".$ruk."";
		  
$programa = "select concat(tt.titulo,' (',ip.item_postulacion,')'), tp.idtipopostulacion as programa ".
    		"from postulaciones as p ".
    		"inner join grupo as g on p.idgrupo = g.idgrupo ".
    		"inner join profesional_postulacion as pp on pp.idpostulacion = p.idpostulacion ".
    		"inner join item_postulacion as ip on p.item_postulacion = ip.iditem_postulacion ".
    		"inner join tipopostulacion as tp on ip.idtipopostulacion = tp.idtipopostulacion ".
    		"inner join titulo_postulacion as tt on tt.idtitulo_postulacion = tp.idtitulo ".
    		"inner join llamado_postulacion lp on lp.idpostulacion = p.idpostulacion ".
    		"where g.numero = ".$ruk." and lp.idllamado = ".$lmd." and lp.anio = ".$anio."";

$postulantes = "select distinct concat(p.nombres,' ', p.paterno,' ', p.materno) as postulante,cp.ncuenta, cn.ahorro, ".
			"cn.subsidio, cn.total, p.rut, p.dv ".	
			"from persona_comite AS pc ".
			"INNER JOIN persona AS p ON pc.rutpersona = p.rut ".
			"INNER JOIN grupo AS g ON pc.idgrupo = g.idgrupo ".
			"INNER JOIN comite_cargo AS c ON pc.idcargo = c.idcargo ".
			"INNER JOIN persona_ficha AS pf ON pf.rutpersona = p.rut ".
			"INNER JOIN persona_vivienda AS pv ON pv.rut = p.rut ".
			"INNER JOIN cuenta_persona AS cp ON cp.rut_titular = p.rut ".
			"INNER JOIN cuenta AS cn ON cn.ncuenta = cp.ncuenta ".
			"INNER JOIN lista_postulantes AS lp ON lp.rutpostulante = pc.rutpersona ".
			"INNER JOIN llamado_postulacion AS llp ON llp.idllamado_postulacion = lp.idllamado_postulacion ".
			"INNER JOIN postulaciones AS ps ON ps.idgrupo = g.idgrupo AND llp.idpostulacion = ps.idpostulacion ".
			"WHERE g.numero = ".$ruk." AND p.estado = 1 AND llp.idllamado = ".$lmd." and llp.anio = ".$anio." ".
			"AND pc.estado = 'Postulante' p.estado = 1 order by p.paterno asc"; 

$sqlpos = mysqli_query($conn, $postulantes);

$g = mysqli_fetch_row(mysqli_query($conn, $datosGrupo));
$t = mysqli_fetch_row(mysqli_query($conn, $programa));

require_once '../../lib/php/phpword/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

$word = new \PhpOffice\PhpWord\TemplateProcessor('plantillas/nomfinanciera2.docx');

$word->setValue('ngrupo', $g[0]);
$word->setValue('numero', $g[1]);
//$word->setValue('');

$n = 1;
$i = 1;

$filas = mysqli_num_rows($sqlpos);

$word->cloneRow('n', $filas);

while ($f = mysqli_fetch_array($sqlpos)) {
	# code...
	$foc = mysqli_fetch_row(mysqli_query($conn, "select mts_original from focalizacion where rutpersona = '".$f[5]."'"));

	$word->setValue('n#'.$i, $n);
	$word->setValue('nompostulante#'.$i, $f[0]);
	$word->setValue('rut#'.$i, $f[5]."-".$f[6] );
	$word->setValue('sub#'.$i,  $f[3]);
	$word->setValue('ah#'.$i, $f[2]);

	if (($t[1] == 4) && ($foc[0] == 1)) {
		# code...
		$ufoc = traerValorConfig("UFFocalizacion");
		$word->setValue('af#'.$i, $ufoc);
	}else{
		$word->setValue('af#'.$i, 0);
	}

	$ssub += $f[3];
	$sah  += $f[2];
	$saf  += $ufoc;

	$n++;
	$i++;
}

$word->setValue('ssub', $ssub);
$word->setValue('sah', $sah);
$word->setValue('saf', $saf);


$word->saveAs("plantillas/results/nomfinanciera2 ".$g[0].".docx");
header("Content-Disposition: attachment; filename=nomfinanciera2 ".$g[0].".docx; charset=iso-8859-1");
echo file_get_contents("plantillas/results/nomfinanciera2 ".$g[0].".docx");

?>