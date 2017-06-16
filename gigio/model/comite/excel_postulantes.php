<?php 
session_start();
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

$cmt = $_GET['cmt'];
$lmd = $_GET['lmd'];

$comite = "select g.nombre, r.REGION_NOMBRE, g.numero, c.COMUNA_NOMBRE from grupo as g ".
		  "INNER JOIN comuna AS c ON g.idcomuna = c.COMUNA_ID ".
		  "INNER JOIN provincia AS p ON c.COMUNA_PROVINCIA_ID = p.PROVINCIA_ID ".
		  "INNER JOIN region AS r ON p.PROVINCIA_REGION_ID = r.REGION_ID ".
		  "WHERE g.idgrupo = ".$cmt."";

$filac = mysqli_fetch_row(mysqli_query($conn, $comite));



$postulantes = "select concat(p.rut, '-', p.dv) AS rut, p.nombres, concat(p.paterno, ' ', p.materno) AS apellidos, ".
		  "g.nombre AS `comité`, c.cargo, cn.total AS `total ahorro`, lp.estado ".	
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
		  "WHERE g.idgrupo = ".$cmt." AND p.estado = 1 AND llp.idllamado = ".$lmd." AND pc.estado = 'Postulante'";

$sql = mysqli_query($conn, $postulantes);

if (mysqli_num_rows($sql) > 0) {

	date_default_timezone_set("America/Santiago");
	

	if (PHP_SAPI == "CLI") {
		die("Este archivo solo es accesible desde un navegador");
	}

	require_once '../../lib/php/phpexcel/Classes/PHPExcel.php';

	$excel = new PHPExcel();


	$excel->getProperties()
	->setCreator($_SESSION['usuario'])
	->setLastModifiedBy($_SESSION['usuario'])
	->setTitle("nomina financiera")
	->setSubject("Documento Excel")
	->setDescription("Documento generado automáticamente")
	->setKeywords("Excel Office 2007 openxml php")
	->setCategory("Prueba");

	$titulo = "Reporte de Postulantes";
	$subtitulo = "Comité: ".$filac[0];
	$columnas = array("Rut", "Nombre", "Apellidos", "Comité", "Cargo", "Ahorro para la vivienda", "Estado");

	$excel->setActiveSheetIndex(0)
	->mergeCells("B2:F2");

	$excel->setActiveSheetIndex(0)
	->mergeCells("B3:F3");


	

	$excel->setActiveSheetIndex(0)
	->setCellValue('B2', $titulo)
	->setCellValue('B3', $subtitulo)
	->setCellValue('B4', 'N°')
	->setCellValue('C4', $columnas[0])
	->setCellValue('D4', $columnas[1])
	->setCellValue('E4', $columnas[2])
	->setCellValue('F4', $columnas[3])
	->setCellValue('G4', $columnas[4])
	->setCellValue('H4', $columnas[5])
	->setCellValue('I4', $columnas[6]);
	
	
	

	$i = 5;
	$n = 1;

	while ($f = mysqli_fetch_array($sql)) {
		$excel->setActiveSheetIndex(0)		
		->setCellValue('B'.$i, $n)
		->setCellValue('C'.$i, strtoupper($f[0]))
		->setCellValue('D'.$i, strtoupper($f[1]))
		->setCellValue('E'.$i, strtoupper($f[2]))
		->setCellValue('F'.$i, strtoupper($f[3]))
		->setCellValue('G'.$i, $f[4])
		->setCellValue('H'.$i, $f[5])
		->setCellValue('I'.$i, $f[6]);	

		$i++;
		$n++;
	}

	$estiloEncabezado = new PHPExcel_Style();
	$estiloEncabezado->applyFromArray( array(
		'font' => array(
			'name' => 'Arial Black',
			'color' => array(
				'rgb' => '000000'
			)
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array(
				'argb' => 'FFFFFF'
			)
		),
		'borders' => array(
			'outline' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,				
			)
		)
	));

	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
	    'font' => array(
	        'name'  => 'Arial',
	        'color' => array(
	            'rgb' => '000000'
	        )
	    ),
	    'fill' => array(
	  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	  'color' => array(
	            'argb' => 'FFFFFF')
	  ),
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN ,
		     	'color' => array(
		              'rgb' => '3a2a47'
	            )
	        )
	    )
	));

	$excel->getActiveSheet()->setSharedStyle($estiloEncabezado, "B2:F3");
	$excel->getActiveSheet()->setSharedStyle($estiloInformacion, "B4:I".($i-1));

	for ($i='B'; $i <= 'I' ; $i++) { 
		$excel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	}

	

	$excel->getActiveSheet()->setTitle($titulo);

	$excel->setActiveSheetIndex(0);

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="nomfinanciera.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	ob_end_clean();
	$objWriter->save('php://output');
	exit;
}else {
	print_r("No se pudo generar el documento");
}




?>