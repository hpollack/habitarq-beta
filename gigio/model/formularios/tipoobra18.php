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

$ruk = mysqli_real_escape_string($conn, $_POST['truk']);
$lmd = $_POST['tllmd'];
$anio = $_POST['tanio'];

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

 $postulantes = "select distinct
				p.rut, p.dv, p.paterno, p.materno, p.nombres,
				concat(d.calle,' ',d.numero) AS direccion,
				d.localidad
				FROM
				persona_comite AS pc
				INNER JOIN persona AS p ON pc.rutpersona = p.rut
				INNER JOIN direccion AS d ON p.rut = d.rutpersona
				INNER JOIN lista_postulantes AS lp ON pc.rutpersona = lp.rutpostulante
				INNER JOIN llamado_postulacion AS llp ON lp.idllamado_postulacion = llp.idllamado_postulacion
				INNER JOIN postulaciones AS ps ON llp.idpostulacion = ps.idpostulacion
				INNER JOIN grupo AS g ON ps.idgrupo = g.idgrupo
				WHERE g.numero = ".$ruk." AND p.estado = 1 AND llp.idllamado = ".$lmd." AND llp.anio = ".$anio." 
				AND pc.estado = 'Postulante' and pe.estado = 1 ORDER BY abs(p.rut) ASC";

$sqlpos = mysqli_query($conn, $postulantes);

$g = mysqli_fetch_row(mysqli_query($conn, $datosGrupo));
$t = mysqli_fetch_row(mysqli_query($conn, $programa));

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel5');

$excel = $reader->load('plantillas/nomtipoobra.xls');

$excel->getActiveSheet()->setCellValue('A4', $t[0]);
$excel->getActiveSheet()->setCellValue('C7', $g[0]);
$excel->getActiveSheet()->setCellValue('G7', $g[2]);

$i = 11;

$n = 1;

while ($f = mysqli_fetch_array($sqlpos)) {

	$excel->setActiveSheetIndex(0)->mergeCells('F'.$i.':G'.$i);
	
	$excel->getActiveSheet()->setCellValue('A'.$i, $n);
	$excel->getActiveSheet()->setCellValue('B'.$i, $f[0]);
	$excel->getActiveSheet()->setCellValue('C'.$i, $f[1]);
	$excel->getActiveSheet()->setCellValue('D'.$i, $f[2]);
	$excel->getActiveSheet()->setCellValue('E'.$i, $f[3]);
	$excel->getActiveSheet()->setCellValue('F'.$i, $f[4]);
	$excel->getActiveSheet()->setCellValue('H'.$i, $f[5]);
	$excel->getActiveSheet()->setCellValue('I'.$i, $f[6]);

	$n++;
	$i++;

}

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

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'A11:J'.($i-1));
$excel->getActiveSheet()->getStyle('A11:J'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->getActiveSheet()->getStyle('A11:J'.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$excel->getActiveSheet()->setCellValue('B'.($i+8), 'NOMBRE FIRMA Y TIMBRE REPRESENTANTE LEGAL ASISTENCIA TECNICA PSAT');
$excel->getActiveSheet()->setCellValue('B'.($i+9), 'NOMBRE PSAT');
$excel->getActiveSheet()->setCellValue('B'.($i+10), 'RUT PSAT');

$excel->getActiveSheet()->setCellValue('H'.($i+8), 'NOMBRE Y FIRMA PRESIDENTE COMITÉ');
$excel->getActiveSheet()->setCellValue('H'.($i+9), 'RUT PRESIDENTE DE COMITÉ');

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="Nomina Tipo Obra '.$g[0].' 2018.xls"'); 
header('Cache-Control: max-age=0'); 

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_end_clean();
$writer->save('php://output');
exit;


?>