<?php 
session_start();

date_default_timezone_set("America/Santiago");

set_time_limit(120);

include_once '../../lib/php/libphp.php';

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

// Datos Nomina
$string =  "select distinct
			p.paterno, p.materno, p.nombres,
			p.rut, p.dv,
			concat(d.calle,' N° ',d.numero) as direccion,
			f.puntaje, v.rol, ec.estado,
			(SELECT `f`.`adultos_mayores` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `adulto mayor`, 
			(SELECT `f`.`hacinamiento` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `hacinamiento`, 
			(SELECT `f`.`discapacidad` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `discapacidad`, 
			(SELECT `f`.`acon_termico` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `acon_termico`, 
			(SELECT `f`.`socavones` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `socavones`,
			(SELECT `f`.`xilofagos` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `xilofagos`,
			(SELECT `f`.`mts_original` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `mts`,
			(SELECT `f`.`sis_term` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `termico`,
			(SELECT `f`.`seg_estruct` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `seg. estructural`,
			(SELECT `f`.`basic_elect` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `electricidad`, 
			(SELECT `f`.`basic_sanit` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `sanitarios`, 
			(SELECT `f`.`basic_alcan` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `alcantarillado`, 
			v.anio,
			(select sum(n.metros) from mts as n where n.idestado_vivienda = 1 and n.rol = v.rol) as mp1,
			(select sum(n.metros) from mts as n where n.idestado_vivienda = 2 and n.rol = v.rol) as mp2,
			v.superficie,
			cp.ncuenta as cuenta,
			v.fojas, v.numero,
			(select vc.fecha from vivienda_certificados as vc where vc.idcertificacion = 2 and vc.rol = v.rol) as anio_es
			from
			persona_comite as pc
			inner join persona as p on p.rut = pc.rutpersona
			inner join focalizacion as ff on ff.rutpersona = p.rut
			inner join direccion as d on d.rutpersona = p.rut
			inner join persona_vivienda as pv on pv.rut = p.rut
			inner join vivienda as v on v.rol = pv.rol
			inner join persona_ficha as pf on pf.rutpersona = p.rut
			inner join frh as f on f.nficha = pf.nficha			
			inner join estado_civil as ec on ec.idestadocivil = f.idestadocivil
			inner join cuenta_persona as cp on cp.rut_titular = p.rut
			inner join lista_postulantes as lp on lp.rutpostulante = p.rut
			inner join llamado_postulacion as llp on llp.idllamado_postulacion = lp.idllamado_postulacion
			inner join postulaciones as ps on ps.idpostulacion = llp.idpostulacion
			inner join grupo as g on g.idgrupo = ps.idgrupo	
			where g.numero = ".$ruk." and llp.idllamado = ".$lmd." and llp.anio = ".$anio." and pc.estado = 'Postulante'
			and p.estado = 1 order by abs(p.rut) asc";

			

$datosPresi = "select concat(p.nombres,' ',p.paterno,' ',p.materno) as nombre, ".
			  "concat(d.calle,' N° ',d.numero) as direccion, " .
			  "c.COMUNA_NOMBRE, r.REGION_NOMBRE, f.numero, f.tipo, concat(p.rut,'-', p.dv) as rut, ".
			  "p.correo ".
			  "from persona as p ".
			  "inner join persona_comite as pc on pc.rutpersona = p.rut ".
			  "inner join direccion as d on d.rutpersona = p.rut ".
			  "inner join fono as f on f.rutpersona = p.rut ".
			  "inner join comuna as c on c.COMUNA_ID = d.idcomuna ".
			  "inner join provincia as pv on pv.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
			  "inner join region as r on r.REGION_ID = pv.PROVINCIA_REGION_ID ".
			  "inner join grupo as g on g.idgrupo = pc.idgrupo ".
			  "where g.numero = ".$ruk." and pc.idcargo = 2";


$sql = mysqli_query($conn, $string);

$p = mysqli_fetch_row(mysqli_query($conn, $datosPresi));

$g = mysqli_fetch_row(mysqli_query($conn, "select nombre, localidad from grupo where numero = ".$ruk.""));

include '../../lib/php/phpexcel/Classes/PHPExcel.php';
include '../../lib/php/phpexcel/Classes/PHPExcel/IOFactory.php';

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel2007');

$excel = $reader->load('plantillas/nomina-comite.xlsx');

$excel->setActiveSheetIndex(0);

//Titulo 
$excel->getActiveSheet()->setCellValue('C1', 'NÓMINA DE POSTULANTES '.$g[0]);

//Nombe del comite.
$excel->getActiveSheet()->setCellValue('C2', $g[0]);

//Localidad o sector
$excel->getActiveSheet()->setCellValue('C5', $g[1]);

// Representante Legal (de existir en la base de datos, si no queda vacio)
$excel->getActiveSheet()->setCellValue('C3', $p[0]);

$i = 9; // Fila donde comienza la iteración

$n = 1; // variable de control de numero de filas

$total = 0;

while ($f = mysqli_fetch_array($sql)) {
	# Filas  a escribirse.
	$excel->getActiveSheet()->setCellValue('A'.$i, $n);
	$excel->getActiveSheet()->setCellValue('B'.$i, $f[0]);
	$excel->getActiveSheet()->setCellValue('C'.$i, $f[1]);
	$excel->getActiveSheet()->setCellValue('D'.$i, $f[2]);
	$excel->getActiveSheet()->setCellValue('E'.$i, $f[3]);
	$excel->getActiveSheet()->setCellValue('F'.$i, $f[4]);
	$excel->getActiveSheet()->setCellValue('G'.$i, $f[5]);
	$excel->getActiveSheet()->setCellValue('H'.$i, $f[6]);
	$excel->getActiveSheet()->setCellValue('I'.$i, $f[7]);
	$excel->getActiveSheet()->setCellValue('J'.$i, $f[8]);
	// 
	if ($f[28] == null) {
		# Se extrae la regularización
		$regl = mysqli_fetch_row(mysqli_query($conn, "select vc.fecha from vivienda_certificados as vc where vc.idcertificacion = 3 and vc.rol = '".$rol."'"));
		if ($regl[0] != null) {
			# Se valida si viene algo.
			$excel->getActiveSheet()->setCellValue('L'.$i, date('Y', $regl[0]));	
		} else {
			# El campo se muestra vacío.
			$excel->getActiveSheet()->setCellValue('L'.$i, date('Y', ''));
		}
		

	} else {

		$excel->getActiveSheet()->setCellValue('L'.$i, date('Y', $f[28]));	
	}
	
	$excel->getActiveSheet()->setCellValue('M'.$i, $f[22]);
	$excel->getActiveSheet()->setCellValue('N'.$i, $f[23]);
	$excel->getActiveSheet()->setCellValue('P'.$i, $f[24]);
	$excel->getActiveSheet()->setCellValue('Q'.$i, $f[25]);
	$excel->getActiveSheet()->setCellValue('R'.$i, $f[26]);
	$excel->getActiveSheet()->setCellValue('S'.$i, $f[27]);
	$excel->getActiveSheet()->setCellValue('T'.$i, $f[21]);
	$suma += $f[6];

	/*
	 Al ser varias foalizaciones, estas se almacenan en un arreglo
	  y se muestran en la celda correspondiente
	*/
	$t = array();
	$focalizaciones = '';

	

	if ($f[9] == 1) {
		$t[0]= 'AM+';
	}else{
		$t[0]= '';
	}

	if ($f[10] == 1) {
		$t[1]= 'HACIN+';
	}else{
		$t[1]= '';
	}

	if ($f[11] == 1) {
		$t[2]= 'DISC+';
	}else{
		$t[2]= '';
	}

	if ($f[12] == 1) {
		$t[3]= 'ACON TER+';
	}else{
		$t[3] = '';
	}
	
	if ($f[13] == 1) {
		$t[4]= 'SOC+';
	}else{
		$t[4]= '';
	}

	if ($f[14] == 1) {
		$t[5]= 'XIL+';
	}else{
		$t[5]= '';
	}

	if ($f[15] == 1) {
		$t[6]= ' < A 40 MTS+';
	}else{
		$t[6]= '';
	}

	if ($f[16] == 1) {
		$t[7]= 'S. TERM+';
	}else {
		$t[7]= '';
	}

	if ($f[17] == 1) {
		$t[8]= 'SEG ESTR+';
	}else{
		$t[8]= '';
	}

	if ($f[18] == 1) {
		$t[9] = 'S.ELECT+';
	}else{
		$t[9] = '';
	}

	if ($f[19] == 1) {
		$t[10] = 'SANIT+';
	}else{
		$t[10] = '';
	}

	if ($f[20] == 1) {
		$t[11] = 'ALCAN+';
	}else{
		$t[11] = '';
	}

	for ($j=0; $j < count($t); $j++) { 
		# Se guarda las focalizaciones como una cadena
		$focalizaciones .= $t[$j];
	}

	

	$excel->getActiveSheet()->setCellValue('K'.$i, $focalizaciones);

	$i++;
	$n++;

	$total++;
}

$excel->getActiveSheet()->setCellValue('C6', $total);
$excel->getActiveSheet()->setCellValue('G'.($i+1), 'PROMEDIO GRUPAL');

$excel->getActiveSheet()->getRowDimension($i)->setRowHeight(30.00);

$prom = $suma/$i;

$excel->getActiveSheet()->setCellValue('H'.($i+1), (float)$prom);

$estiloNomina = new PHPExcel_Style();
$estiloNomina->applyFromArray( array(
	'font' => array(
		'name' => 'Calibri',
		'color' => array(
			'rgb' => '000000'
		)		
	),	
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array(
				'rgb' => '000000'
			)
		)
	)
));

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'A9:T'.($i-1));
$excel->getActiveSheet()->getStyle('A9:T'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

mysqli_close($conn);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="nomina-comite-'.$g[0].'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
ob_end_clean();
$writer->save('php://output');
exit;
?>