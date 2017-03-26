<?php 
session_start();
include_once '../../lib/php/libphp.php';



$conn = conectar();

$cmt = $_GET['cmt'];
$lmd = $_GET['lmd'];

$comite = "select g.nombre, r.REGION_NOMBRE, g.numero, c.COMUNA_NOMBRE from grupo as g ".
		  "INNER JOIN comuna AS c ON g.idcomuna = c.COMUNA_ID ".
		  "INNER JOIN provincia AS p ON c.COMUNA_PROVINCIA_ID = p.PROVINCIA_ID ".
		  "INNER JOIN region AS r ON p.PROVINCIA_REGION_ID = r.REGION_ID ".
		  "WHERE g.idgrupo = ".$cmt."";

$filac = mysqli_fetch_row(mysqli_query($conn, $comite));



$postulantes = "select p.paterno, p.materno, p.nombres, ".
			   "c.ncuenta, c.ahorro, c.subsidio, c.total, p.rut, p.dv  ".
			   "from lista_postulantes as lp ".
			   "inner join persona_comite as pc on lp.rutpostulante = pc.rutpersona ".
			   "inner join persona as p on p.rut = lp.rutpostulante ".
			   "inner join cuenta_persona as cp on cp.rut_titular = p.rut ".
			   "inner join cuenta as c on c.ncuenta = cp.ncuenta ".			   
			   "where pc.idgrupo = ".$cmt." and lp.idllamado_postulacion = ".$lmd."";

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

	$titulo = "Nómina Financiera ";
	$columnas = array("Apellido Paterno", "Apellido Materno", "Nombres", "N° De Cuenta", "Ahorro", "Subsidio", "Ahorro de la vivienda", "Rut");

	$excel->setActiveSheetIndex(0)
	->mergeCells("B2:F2");

	
	$excel->setActiveSheetIndex(0)
	->mergeCells("B3:F4");

	$excel->setActiveSheetIndex(0)
	->mergeCells("B5:F5");

	$excel->setActiveSheetIndex(0)
	->mergeCells("B7:C7");

	$excel->setActiveSheetIndex(0)
	->mergeCells("D7:E7");	

	$excel->setActiveSheetIndex(0)
	->mergeCells("J9:L10");

	$titulo2  = " D.S N° 255 ( V. Y U.) DE 2006\nNÓMINA DE POSTULANTES : POSTULACION COLECTIVA";

	$excel->setActiveSheetIndex(0)
	->setCellValue("B2", " PROGRAMA DE PROTECCION DEL PATRIMONIO FAMILIAR")		
	->setCellValue("B3", $titulo2)
	->setCellValue("B5", "TÍTULO II PPPF- REGULAR (Habitabilidad de la Vivienda)")
	->setCellValue("B7","Nombre del Grupo")
	->setCellValue("D7", $filac[0])
	->setCellValue("F7", $filac[3])
	->setCellValue("J7", "Región")
	->setCellValue("K7", $filac[1]) // Esto se debe cambiar por el numero
	->setCellValue("M7", "Codigo: ".$filac[2])	
	->setCellValue("B9", "N° Identificación del Postulante ( por orden alfabético )")
	->setCellValue("C10", $columnas[0])
	->setCellValue("D10", $columnas[1])
	->setCellValue("E10", $columnas[2])
	->setCellValue("F10", $columnas[3])
	->setCellValue("G10", $columnas[4])
	->setCellValue("H10", $columnas[5])
	->setCellValue("I10", $columnas[6])
	->setCellValue("J9", $columnas[7]);	

	$i = 11;
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
		->setCellValue('I'.$i, $f[6])
		->setCellValue('J'.$i, $f[7])
		->setCellValue('L'.$i, $f[8]);

		$i++;
		$n++;
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