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

 $postulantes = "select p.paterno, p.materno, p.nombres, cp.ncuenta, cn.ahorro, ".
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
				"AND pc.estado = 'Postulante' order by p.paterno asc"; 

$sqlpos = mysqli_query($conn, $postulantes);

$g = mysqli_fetch_row(mysqli_query($conn, $datosGrupo));
$t = mysqli_fetch_row(mysqli_query($conn, $programa));

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel2007');

$excel = $reader->load('plantillas/nomfinanciera.xlsx');

$excel->setActiveSheetIndex(0);

$excel->getActiveSheet()->setCellValue('B5', $t[0]);
$excel->getActiveSheet()->setCellValue('D7', $g[0]);
$excel->getActiveSheet()->setCellValue('F7', $g[2]);
$excel->getActiveSheet()->setCellValue('K7', $g[3]);
$excel->getActiveSheet()->setCellValue('M7', 'Código '.$g[1]);


$i = 11;
$n = 1;

while ($f = mysqli_fetch_array($sqlpos)) {
	$foc = mysqli_fetch_row(mysqli_query($conn, "select mts_original from focalizacion where rutpersona = '".$f[7]."'"));

	$excel->getActiveSheet()->setCellValue('B'.$i, $n);
	$excel->getActiveSheet()->setCellValue('C'.$i, strtoupper($f[0]));
	$excel->getActiveSheet()->setCellValue('D'.$i, strtoupper($f[1]));
	$excel->getActiveSheet()->setCellValue('E'.$i, strtoupper($f[2]));
	$excel->getActiveSheet()->setCellValue('F'.$i, $f[3]);
	$excel->getActiveSheet()->setCellValue('G'.$i, $f[4]);
	$excel->getActiveSheet()->setCellValue('H'.$i, $f[5]);

	if (($t[1] == 4) && ($foc[0] == 1)) {
		$ufoc = traerValorConfig("UFFocalizacion");
		$suma = $f[6] + $ufoc;
	}else{
		$suma = $f[6];
	}

	$excel->getActiveSheet()->setCellValue('I'.$i, $suma);
	$excel->getActiveSheet()->setCellValue('J'.$i, $f[7]);
	$excel->getActiveSheet()->setCellValue('L'.$i, $f[8]);
	$excel->getActiveSheet()->mergeCells('M'.$i.':N'.$i);

	$excel->getActiveSheet()->getRowDimension($i)->setRowHeight(45.00);
	
	$sumAhorro += $f[4];
	$sumSubsidio += $f[5];
	$sumTotal += $suma;

	$i++;
	$n++;
}

$excel->getActiveSheet()->setCellValue('G'.$i, $sumAhorro);
$excel->getActiveSheet()->setCellValue('H'.$i, $sumSubsidio);
$excel->getActiveSheet()->setCellValue('I'.$i, $sumTotal);


$excel->getActiveSheet()->setCellValue('C'.($i+5), 'FIRMA');
$excel->getActiveSheet()->setCellValue('C'.($i+6), 'PRESIDENTE DEL COMITÉ');

$excel->getActiveSheet()->setCellValue('G'.($i+5), 'FIRMA');
$excel->getActiveSheet()->setCellValue('G'.($i+6), 'ASISTENCIA TÉCNICA');

$estiloNomina = new PHPExcel_Style();
$estiloNomina->applyFromArray( array(
	'font' => array(
		'name' => 'Calibri',
		'color' => array(
			'rgb' => '000000'
		)		
	),
	'fill' => array(
	  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	  'color' => array(
	        'argb' => 'FFFFFF'
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

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'B11:N'.($i-1));
$excel->getActiveSheet()->getStyle('B11:N'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->getActiveSheet()->getStyle('B11:N'.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$excel->getActiveSheet()->setSharedStyle($estiloTotales, 'G'.$i.':I'.$i);

mysqli_close($conn);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="nomfinaciera '.$g[0].'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
ob_end_clean();
$writer->save('php://output');
exit;
?>