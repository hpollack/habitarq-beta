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

$ruk = mysqli_real_escape_string($conn, $_POST['aruk']);
$lmd = $_POST['allmd'];
$anio = $_POST['aanio'];

$comite = "select g.nombre as postulantes ".
		  "FROM lista_postulantes AS pl ".
		  "INNER JOIN llamado_postulacion AS lp ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
		  "INNER JOIN postulaciones AS p ON lp.idpostulacion = p.idpostulacion ".
		  "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
		  "inner join persona_vivienda as pv on pv.rut = pl.rutpostulante ".
		  "inner join vivienda as v on v.rol = pv.rol ".
		  "WHERE g.numero = ".$ruk." and lp.idllamado = ".$lmd."  and lp.anio = ".$anio." ".
		  "group by g.nombre";	

$nomina = "select p.paterno, p.materno, p.nombres, p.rut, p.dv, concat(d.calle,' N°',d.numero) as direccion, v.rol, ".
		  "(select metros from mts where mts.rol = v.rol and mts.idpiso = 1 and mts.idestado_vivienda = 1) as piso1, ".
		  "(select metros from mts where mts.rol = v.rol and mts.idpiso = 2 and mts.idestado_vivienda = 1) as piso2, ".
		  "(select metros from mts where mts.rol = v.rol and mts.idpiso = 1 and mts.idestado_vivienda = 2) as amp1, ".
		  "(select metros from mts where mts.rol = v.rol and mts.idpiso = 2 and mts.idestado_vivienda = 2) as amp2, ".
		  "v.superficie ".		  
		  "FROM lista_postulantes AS pl ".
		  "INNER JOIN llamado_postulacion AS lp ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
		  "INNER JOIN postulaciones AS ps ON lp.idpostulacion = ps.idpostulacion ".
		  "INNER JOIN grupo AS g ON g.idgrupo = ps.idgrupo ".
		  "inner join persona_vivienda as pv on pv.rut = pl.rutpostulante ".
		  "inner join persona as p on p.rut = pv.rut ".
		  "inner join direccion as d on d.rutpersona = p.rut ".
		  "inner join vivienda as v on v.rol = pv.rol ".
		  "WHERE g.numero = ".$ruk." and lp.idllamado = ".$lmd."  and lp.anio = ".$anio."";

$c = mysqli_fetch_row(mysqli_query($conn, $comite));

$sql = mysqli_query($conn, $nomina);

$excel = new PHPExcel();
$reader = $reader = PHPExcel_IOFactory::createReader('Excel2007');

$excel = $reader->load('plantillas/nomina-ampliacion.xlsx');

$excel->setActiveSheetIndex(0);

$excel->getActiveSheet()->setCellValue('D5', $c[0]);

$i = 9;
$n = 1;

while ($f = mysqli_fetch_array($sql)) {
	$excel->getActiveSheet()->setCellValue('B'.$i, $n);
	$excel->getActiveSheet()->setCellValue('C'.$i, strtoupper($f[0]));
	$excel->getActiveSheet()->setCellValue('D'.$i, strtoupper($f[1]));
	$excel->getActiveSheet()->setCellValue('E'.$i, strtoupper($f[2]));
	$excel->getActiveSheet()->setCellValue('F'.$i, $f[3]);
	$excel->getActiveSheet()->setCellValue('G'.$i, $f[4]);
	$excel->getActiveSheet()->setCellValue('H'.$i, $f[5]);
	$excel->getActiveSheet()->setCellValue('I'.$i, $f[6]);
	$excel->getActiveSheet()->setCellValue('J'.$i, $f[7]);
	$excel->getActiveSheet()->setCellValue('K'.$i, $f[8]);
	$excel->getActiveSheet()->setCellValue('L'.$i, ($f[9] + $f[10]));
	$excel->getActiveSheet()->setCellValue('M'.$i, '=L'.$i.'+K'.$i.'+J'.$i);
	$excel->getActiveSheet()->setCellValue('N'.$i, '');
	$excel->getActiveSheet()->setCellValue('O'.$i, '=N'.$i.'+M'.$i);
	$excel->getActiveSheet()->setCellValue('P'.$i, $f[11]);


	$i++;
	$n++;
}

$estiloNomina = new PHPExcel_Style();
$estiloNomina->applyFromArray( array(
	'font' => array(
		'name' => 'Calibri',
		'size' => 14,
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


$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'B9:Q'.($i-1));
$excel->getActiveSheet()->getStyle('B9:Q'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->getActiveSheet()->getStyle('B9:Q'.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

mysqli_close($conn);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="nomina ampliacion '.$c[0].'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
ob_end_clean();
$writer->save('php://output');
exit;
		  			  
?>