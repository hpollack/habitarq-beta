<?php 

session_start();


date_default_timezone_set("America/Santiago");

include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$ruk = $_POST['ruk'];

include '../../lib/php/phpexcel/Classes/PHPExcel.php';
include '../../lib/php/phpexcel/Classes/PHPExcel/IOFactory.php';

$string = "select DISTINCT
concat(p.rut,'-',p.dv) AS rut, 
concat(p.nombres,' ',p.paterno,' ',p.materno) AS nombre, 
concat(d.calle,' N° ',d.numero) as direccion, 
v.rol, 
(select p1.metros from mts p1 where p1.rol = v.rol and p1.idpiso = 1 and idestado_vivienda = 1) AS p1, 
(select p2.metros from mts p2 where p2.rol = v.rol and p2.idpiso = 2 and idestado_vivienda = 1) AS p2,
(select mts.metros from mts where mts.idestado_vivienda = 2 and mts.rol = v.rol) as amp,
(select mts.idpiso from mts where mts.idestado_vivienda = 2 and mts.rol = v.rol) as piso
FROM
vivienda AS v
INNER JOIN persona_vivienda AS pv ON pv.rol = v.rol
INNER JOIN persona AS p ON pv.rut = p.rut
INNER JOIN direccion as d ON p.rut = d.rutpersona
INNER JOIN lista_postulantes lp ON p.rut = lp.rutpostulante
INNER JOIN mts AS mv ON mv.rol = v.rol
INNER JOIN piso AS pm ON mv.idpiso = pm.idpiso
INNER JOIN conservador AS cv ON v.conservador = cv.idconservador
INNER JOIN persona_comite AS pg ON p.rut = pg.rutpersona
INNER JOIN grupo AS g ON pg.idgrupo = g.idgrupo
WHERE g.numero = ".$ruk."";

$sql = mysqli_query($conn,$string);

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel2007');

$excel = $reader->load('../formularios/plantillas/nomina-ine.xlsx');

$excel->setActiveSheetIndex(0);

$i = 6;
$n = 1;

while ($f = mysqli_fetch_array($sql)) {	
	
	
	$excel->getActiveSheet()->setCellValue('B'.$i, $n);
	$excel->getActiveSheet()->setCellValue('C'.$i, $f[1]);
	$excel->getActiveSheet()->setCellValue('D'.$i, $f[0]);
	$excel->getActiveSheet()->setCellValue('E'.$i, $f[2]);
	$excel->getActiveSheet()->setCellValue('F'.$i, $f[3]);
	$excel->getActiveSheet()->setCellValue('G'.$i, ($f[4] + $f[5]));

	$amp = ($f[6] > 0) ? $f[6] : 0;	

	$excel->getActiveSheet()->setCellValue('H'.$i, $amp);
	$excel->getActiveSheet()->setCellValue('I'.$i, ((($f[4] + $f[5]) + $amp)));
	
	if ($f[7] == 1) {
		
		$piso = "1° Piso";
	}else if ($f[7] == 2) {
		
		$piso = "2° Piso";
	}else {
		$piso = "";
	}

	$excel->getActiveSheet()->setCellValue('J'.$i, $piso);

	$excel->getActiveSheet()->getRowDimension($i)->setRowHeight(30.00);


	$i++;
	$n++;

	$tamp += $amp;
}

$excel->getActiveSheet()->setCellValue('G'.($i+2), 'TOTALES');
$excel->getActiveSheet()->setCellValue('H'.($i+2), $tamp);


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

$total = new PHPExcel_Style();
$total->applyFromArray( array(
	'font' => array(
		'name' => 'Calibri',
		'size' => 14,
		'bold' => true,
		'italic' => true,
		'color' => array(
			'rgb' => '000000'
		)
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	)	
));

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'B6:K'.($i-1));
$excel->getActiveSheet()->getStyle('B6:K'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->getActiveSheet()->getStyle('B6:K'.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$excel->getActiveSheet()->getStyle('B6:K'.($i-1))->getAlignment()->setWrapText(true);

$excel->getActiveSheet()->setSharedStyle($total, 'G'.($i+2).':H'.($i+2));

mysqli_close($conn);


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="nomina-ine.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
ob_end_clean();
$writer->save('php://output');
exit;

?>