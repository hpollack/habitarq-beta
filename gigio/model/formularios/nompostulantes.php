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

date_default_timezone_set("America/Santiago");


$conn = conectar();

include '../../lib/php/phpexcel/Classes/PHPExcel.php';
include '../../lib/php/phpexcel/Classes/PHPExcel/IOFactory.php';

$ruk = mysqli_real_escape_string($conn, $_POST['ruk2']);
$lmd = $_POST['llmd1'];
$anio = $_POST['panio'];

$datosGrupo = "select g.nombre, g.numero, c.COMUNA_NOMBRE, r.REGION_ID from grupo as g ".
			  "inner join comuna as c on c.COMUNA_ID = g.idcomuna ".
			  "inner join provincia as p on p.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
			  "inner join region as r on r.REGION_ID = p.PROVINCIA_REGION_ID ".
			  "where g.numero = ".$ruk."";
		  

$programa = "select concat(tt.titulo,' (',ip.item_postulacion,')') as programa ".
    		"from postulaciones as p ".
    		"inner join grupo as g on p.idgrupo = g.idgrupo ".
    		"inner join profesional_postulacion as pp on pp.idpostulacion = p.idpostulacion ".
    		"inner join item_postulacion as ip on p.item_postulacion = ip.iditem_postulacion ".
    		"inner join tipopostulacion as tp on ip.idtipopostulacion = tp.idtipopostulacion ".
    		"inner join titulo_postulacion as tt on tt.idtitulo_postulacion = tp.idtitulo ".
    		"inner join llamado_postulacion lp on lp.idpostulacion = p.idpostulacion ".
    		"where g.numero = ".$ruk." and lp.idllamado = ".$lmd." and lp.anio = ".$anio."";

 $postulantes = "select p.paterno, p.materno, p.nombres, p.rut, p.dv ".	
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
$reader = PHPExcel_IOFactory::createReader('Excel5');

$excel = $reader->load('plantillas/nompostulantes.xls');

$excel->setActiveSheetIndex(0);

$excel->getActiveSheet()->setCellValue('A5', $t[0]);
$excel->getActiveSheet()->setCellValue('A7', 'Nombre del Grupo: '.$g[0].' Comuna:'.$g[2]." Región ".$g[3]."°");


$i = 11;
$n = 1;

while ($f = mysqli_fetch_array($sqlpos)) {
	$excel->getActiveSheet()->setCellValue('A'.$i, $n);
	$excel->getActiveSheet()->setCellValue('B'.$i, strtoupper($f[0]));
	$excel->getActiveSheet()->setCellValue('C'.$i, strtoupper($f[1]));
	$excel->getActiveSheet()->setCellValue('D'.$i, strtoupper($f[2]));
	$excel->getActiveSheet()->setCellValue('E'.$i, $f[3]);
	$excel->getActiveSheet()->setCellValue('G'.$i, $f[4]);

	$excel->getActiveSheet()->getRowDimension($i)->setRowHeight(22.50);
	
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
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array(
				'rgb' => '000000'
			)
		)
	)
));

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'A11:G'.($i-1));
$excel->getActiveSheet()->getStyle('A11:G'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

mysqli_close($conn);

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="nomina postulantes'.$g[0].'.xls"'); 
header('Cache-Control: max-age=0'); 

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_end_clean();
$writer->save('php://output');
exit;
?>