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

include '../../lib/php/phpexcel/Classes/PHPExcel.php';
include '../../lib/php/phpexcel/Classes/PHPExcel/IOFactory.php';

$ruk = mysqli_real_escape_string($conn, $_POST['ruk1']);
$lmd = $_POST['llmd'];
$anio = $_POST['ganio'];

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

 $postulantes = "select distinct p.paterno, p.materno, p.nombres, cp.ncuenta, cn.ahorro, ".
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
				"AND pc.estado = 'Postulante' and p.estado = 1 order by abs(p.rut) asc"; 

$sqlpos = mysqli_query($conn, $postulantes);

$g = mysqli_fetch_row(mysqli_query($conn, $datosGrupo));
$t = mysqli_fetch_row(mysqli_query($conn, $programa));

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel5');

$excel = $reader->load('plantillas/nomfinanciera18.xls');


$excel->getActiveSheet()->setCellValue('A4', $t[0]);
$excel->getActiveSheet()->setCellValue('C7', $g[0]);
$excel->getActiveSheet()->setCellValue('G7', $g[2]);
$excel->getActiveSheet()->setCellValue('C9', $g[1]);


$n = 1;
$i = 11; 

while ($f = mysqli_fetch_array($sqlpos)) {

	// Monto de focalizacion si el valor es menor al de la configuracion en metros.
	$foc = mysqli_fetch_row(mysqli_query($conn, "select mts_original from focalizacion where rutpersona = '".$f[7]."'"));

	$excel->setActiveSheetIndex(0)->mergeCells('F'.$i.':G'.$i);
	
	$excel->getActiveSheet()->setCellValue('A'.$i, $n);
	$excel->getActiveSheet()->setCellValue('B'.$i, $f[7]);
	$excel->getActiveSheet()->setCellValue('C'.$i, $f[8]);
	$excel->getActiveSheet()->setCellValue('D'.$i, $f[0]);
	$excel->getActiveSheet()->setCellValue('E'.$i, $f[1]);	
	$excel->getActiveSheet()->setCellValue('F'.$i, $f[2]);
	$excel->getActiveSheet()->setCellValue('H'.$i, $f[5]);
	$excel->getActiveSheet()->setCellValue('I'.$i, $f[4]);

	if (($t[1] == 4) && ($foc[0] == 1)) {
		$ufoc = traerValorConfig("UFFocalizacion");
		$suma = $f[6] + $ufoc;
	}else{
		$suma = $f[6];
	}

	$excel->getActiveSheet()->setCellValue('J'.$i, $suma);

	$tahorro += $f[4];
	$tsubs   += $f[5];
	$total   += $suma;

	$i++;
	$n++;
}

$excel->getActiveSheet()->setCellValue('G'.$i, 'TOTAL');
$excel->getActiveSheet()->setCellValue('H'.$i, $tsubs);
$excel->getActiveSheet()->setCellValue('I'.$i, $tahorro);
$excel->getActiveSheet()->setCellValue('J'.$i, $total);

// ESTILO DE NOMINA
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

// EStilo del la fila de totales
$estiloTotales = new PHPExcel_Style();
$estiloTotales->applyFromArray( array(
	'font' => array(
		'name' => 'Helvetica',
		'size' => 12,
		'bold' => true,
		'color' => array(
			'rgb' => '000000'
		)
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
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

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'A11:J'.($i-1));
$excel->getActiveSheet()->getStyle('A11:J'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->getActiveSheet()->getStyle('A11:J'.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$excel->getActiveSheet()->setSharedStyle($estiloTotales, 'G'.$i.':J'.$i);

$excel->getActiveSheet()->setCellValue('B'.($i+9), 'NOMBRE FIRMA Y TIMBRE REPRESENTANTE LEGAL ASISTENCIA TECNICA PSAT
');
$excel->getActiveSheet()->setCellValue('B'.($i+10), 'NOMBRE PSAT');
$excel->getActiveSheet()->setCellValue('B'.($i+11), 'RUT PSAT');

$excel->getActiveSheet()->setCellValue('B'.($i+22), 'NOMBRE Y FIRMA DEL PRESIDENTE DEL COMITE');
$excel->getActiveSheet()->setCellValue('B'.($i+23), 'RUT PRESIDENTE DEL COMITE');

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="Nomina Financiera '.$g[0].' 2018.xls"'); 
header('Cache-Control: max-age=0'); 

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_end_clean();
$writer->save('php://output');
exit;



?>