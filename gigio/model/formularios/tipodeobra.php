<?php 
session_start();

date_default_timezone_set("America/Santiago");

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

include '../../lib/php/phpexcel/Classes/PHPExcel.php';
include '../../lib/php/phpexcel/Classes/PHPExcel/IOFactory.php';

$ruk = mysqli_real_escape_string($conn, $_POST['truk']);
$lmd = $_POST['tllmd'];
$anio = $_POST['tanio'];

$egis  = "select  e.nombre, e.correo from egis as e ".
		 "inner join grupo as g on g.idegis = e.idegis ".
		 "inner join comuna as c on c.COMUNA_ID = e.idcomuna ".
		 "inner join provincia as p on p.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
		 "inner join region as r on r.REGION_ID = p.PROVINCIA_REGION_ID ".
		 "where g.numero = ".$ruk."";	

$comite = "select g.nombre as postulantes ".
		  "FROM lista_postulantes AS pl ".
		  "INNER JOIN llamado_postulacion AS lp ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
		  "INNER JOIN postulaciones AS p ON lp.idpostulacion = p.idpostulacion ".
		  "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
		  "inner join persona_vivienda as pv on pv.rut = pl.rutpostulante ".
		  "inner join vivienda as v on v.rol = pv.rol ".
		  "WHERE g.numero = ".$ruk." and lp.idllamado = ".$lmd."  and lp.anio = ".$anio." ".
		  "group by g.nombre";	

$nomina = "select concat(p.rut,'-',p.dv) as rut, concat(p.nombres,' ',p.paterno,' ',p.materno) as nombre, ".
		  "concat(d.calle,' ',d.numero) as direccion ".	
		  "FROM lista_postulantes AS pl ".
		  "INNER JOIN llamado_postulacion AS lp ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
		  "INNER JOIN postulaciones AS ps ON lp.idpostulacion = ps.idpostulacion ".
		  "INNER JOIN grupo AS g ON g.idgrupo = ps.idgrupo ".
		  "inner join persona_vivienda as pv on pv.rut = pl.rutpostulante ".
		  "inner join persona as p on p.rut = pv.rut ".
		  "inner join direccion as d on d.rutpersona = p.rut ".
		  "inner join vivienda as v on v.rol = pv.rol ".
		  "WHERE g.numero = ".$ruk." and lp.idllamado = ".$lmd."  and lp.anio = ".$anio."";


$e = mysqli_fetch_row(mysqli_query($conn, $egis));
$c = mysqli_fetch_row(mysqli_query($conn, $comite));

$sql = mysqli_query($conn, $nomina);

$excel = new PHPExcel();
$reader = $reader = PHPExcel_IOFactory::createReader('Excel2007');

$excel = $reader->load('plantillas/tipo-de-obra.xlsx');

$excel->setActiveSheetIndex(0);

$excel->getActiveSheet()->setCellValue('B10', $e[0]);
$excel->getActiveSheet()->setCellValue('B11', $e[1]);

$excel->getActiveSheet()->setCellValue('C10', $c[0]);

$i = 16;
$n = 1;

while ($f = mysqli_fetch_array($sql)) {
	$excel->getActiveSheet()->setCellValue('A'.$i, $n);
	$excel->getActiveSheet()->setCellValue('B'.$i, strtoupper($f[1]));
	$excel->getActiveSheet()->setCellValue('C'.$i, $f[0]);
	$excel->getActiveSheet()->setCellValue('D'.$i, $f[2]);

	$i++;
	$n++;
}

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


$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'A16:E'.($i-1));
$excel->getActiveSheet()->getStyle('A16:E'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->getActiveSheet()->getStyle('A16:E'.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

mysqli_close($conn);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="nomina tipo de obra '.$c[0].'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
ob_end_clean();
$writer->save('php://output');
exit;
		  			  
?>