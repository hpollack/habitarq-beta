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

$ruk = mysqli_real_escape_string($conn, $_POST['ruk3']);
$lmd = $_POST['llmd3'];
$anio = $_POST['nanio'];

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

$nomina = "select p.paterno, p.materno, p.nombres, p.rut, p.dv, f.puntaje, v.anio_recepcion ".
		  "from frh as f ".
		  "inner join persona_ficha as pf on pf.nficha = f.nficha ".
		  "inner join persona as p on p.rut = pf.rutpersona ".
		  "inner join lista_postulantes as lp on lp.rutpostulante = pf.rutpersona ".
		  "inner join llamado_postulacion as ll on ll.idllamado_postulacion = lp.idllamado_postulacion ".
          "inner join llamados as l on l.idllamados = ll.idllamado ".
          "inner join postulaciones as ps on ps.idpostulacion = ll.idpostulacion ".
          "inner join grupo as g on g.idgrupo = ps.idgrupo ".
          "inner join persona_vivienda as pv on pv.rut = lp.rutpostulante ".
          "inner join vivienda as v on v.rol = pv.rol ".
          "where g.numero = ".$ruk." and ll.idllamado = ".$lmd." and ll.anio = ".$anio."";

$promedios = "select round(avg(f.puntaje)) as prompuntaje, ".
		 	 "round(avg(v.anio_recepcion)) as promanio ".
		  	 "from frh as f ".
		 	 "inner join persona_ficha as pf on pf.nficha = f.nficha ".
		     "inner join persona as p on p.rut = pf.rutpersona ".
		 	 "inner join lista_postulantes as lp on lp.rutpostulante = pf.rutpersona ".
		 	 "inner join llamado_postulacion as ll on ll.idllamado_postulacion = lp.idllamado_postulacion ".
         	 "inner join llamados as l on l.idllamados = ll.idllamado ".
         	 "inner join postulaciones as ps on ps.idpostulacion = ll.idpostulacion ".
         	 "inner join grupo as g on g.idgrupo = ps.idgrupo ".
         	 "inner join persona_vivienda as pv on pv.rut = lp.rutpostulante ".
         	 "inner join vivienda as v on v.rol = pv.rol ".
         	 "where g.numero = ".$ruk." and ll.idllamado = ".$lmd." and ll.anio = ".$anio."";

$g = mysqli_fetch_row(mysqli_query($conn, $datosGrupo));
$t = mysqli_fetch_row(mysqli_query($conn, $programa));   
$p = mysqli_fetch_row(mysqli_query($conn, $promedios));

$sqlpuntaje = mysqli_query($conn, $nomina);

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel5');

$excel = $reader->load('plantillas/nompuntaje.xls');

$excel->setActiveSheetIndex(0);

$region = explode('Región ', $g[3]);

$excel->getActiveSheet()->setCellValue('A4', $t[0]);
$excel->getActiveSheet()->setCellValue('A6', "Nombre del Grupo: ".$g[0]);
$excel->getActiveSheet()->setCellValue('E6', 'Comuna: '.$g[2]);
$excel->getActiveSheet()->setCellValue('I6', $region[0]);
$excel->getActiveSheet()->setCellValue('B7', 'Código: '.$g[1]);

$i = 10;
$n = 1;

while ($f = mysqli_fetch_array($sqlpuntaje)) {
	$excel->getActiveSheet()->setCellValue('A'.$i, $n);
	$excel->getActiveSheet()->setCellValue('B'.$i, strtoupper($f[0]));
	$excel->getActiveSheet()->setCellValue('C'.$i, strtoupper($f[1]));
	$excel->getActiveSheet()->setCellValue('D'.$i, strtoupper($f[2]));
	$excel->getActiveSheet()->setCellValue('E'.$i, $f[3]);
	$excel->getActiveSheet()->setCellValue('G'.$i, $f[4]);
	$excel->getActiveSheet()->setCellValue('H'.$i, $f[5].'%');
	$excel->getActiveSheet()->setCellValue('I'.$i, $f[6]);

	$excel->getActiveSheet()->getRowDimension($i)->setRowHeight(24.75);

	$i++;
	$n++;
}
$excel->getActiveSheet()->setCellValue('E'.$i, 'PROMEDIO GRUPO ');
$excel->getActiveSheet()->setCellValue('H'.$i, $p[0].'%');
$excel->getActiveSheet()->setCellValue('I'.$i, $p[1]);

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

$estiloPorcentaje = new PHPExcel_Style();
$estiloPorcentaje->applyFromArray( array(
	'font' => array(
		'bold' => true
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array(
			'argb' => 'BDBDBD'
		)		
	),
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'size' => 2,
	     	'color' => array(
	              'rgb' => '000000'
            )
		)
	)
));

$excel->getActiveSheet()->getStyle('E'.$i.':I'.$i)->getFont()->setBold(true);
$excel->getActiveSheet()->getRowDimension($i)->setRowHeight(21.00);

$excel->getActiveSheet()->setSharedStyle($estiloPorcentaje, 'H'.$i);
$excel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(16);
$excel->getActiveSheet()->getStyle('I'.$i)->getFont()->setSize(12);

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'A10:I'.($i-1));
$excel->getActiveSheet()->getStyle('A10:I'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$excel->getActiveSheet()->getStyle('A10:I'.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="nomina puntaje y antiguedad '.$g[0].'.xls"'); 
header('Cache-Control: max-age=0'); 

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_end_clean();
$writer->save('php://output');
exit;



?>