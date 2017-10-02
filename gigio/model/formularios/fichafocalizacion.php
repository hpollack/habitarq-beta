<?php  


session_start();
date_default_timezone_set("America/Santiago");

include_once '../../lib/php/libphp.php';
include '../../lib/php/phpexcel/Classes/PHPExcel.php';
include '../../lib/php/phpexcel/Classes/PHPExcel/IOFactory.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$ruk = mysqli_real_escape_string($conn, $_POST['ruk2']);
$lmd = $_POST['llmd1'];
$anio = $_POST['panio'];

$datosGrupo = "select g.nombre, g.numero, c.COMUNA_NOMBRE, r.REGION_ID from grupo as g ".
			  "inner join comuna as c on c.COMUNA_ID = g.idcomuna ".
			  "inner join provincia as p on p.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
			  "inner join region as r on r.REGION_ID = p.PROVINCIA_REGION_ID ".
			  "where g.numero = ".$ruk."";

$programa = "select ip.item_postulacion as programa ".
    		"from postulaciones as p ".
    		"inner join grupo as g on p.idgrupo = g.idgrupo ".
    		"inner join profesional_postulacion as pp on pp.idpostulacion = p.idpostulacion ".
    		"inner join item_postulacion as ip on p.item_postulacion = ip.iditem_postulacion ".
    		"inner join tipopostulacion as tp on ip.idtipopostulacion = tp.idtipopostulacion ".
    		"inner join titulo_postulacion as tt on tt.idtitulo_postulacion = tp.idtitulo ".
    		"inner join llamado_postulacion lp on lp.idpostulacion = p.idpostulacion ".
    		"where g.numero = ".$ruk." and lp.idllamado = ".$lmd." and lp.anio = ".$anio.""; 

$postulantes = 	"SELECT concat(`p`.`rut`, '-', `p`.`dv`) AS `rut`, ". //0
				"concat(`p`.`nombres`,' ', `p`.`paterno`,' ', `p`.`materno`) AS `nombre`, ". // 1
				"(SELECT `f`.`adultos_mayores` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `adulto mayor`, ". //2
				"(SELECT `f`.`hacinamiento` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `hacinamiento`, ". //3
				"(SELECT `f`.`discapacidad` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `discapacidad`, ". //4
				"(SELECT `f`.`acon_termico` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `acon_termico`, ". //5
				"(SELECT `f`.`socavones` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `socavones`, ". //6
				"(SELECT `f`.`xilofagos` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `xilofagos`, ". //7
				"(SELECT `f`.`mts_original` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `mts`, ". //8
				"(SELECT `f`.`sis_term` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `termico`, ". //9
				"(SELECT `f`.`seg_estruct` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `seg. estructural`, ". //10
				"(SELECT `f`.`basic_elect` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `electricidad`, ". //11
				"(SELECT `f`.`basic_sanit` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `sanitarios`, ". //12
				"(SELECT `f`.`basic_alcan` FROM `focalizacion` `f` WHERE `f`.`rutpersona` = `p`.`rut`) AS `alcantarillado`, ". //13
				"`g`.`nombre`, `g`.`numero` ".
				"FROM `postulaciones` `ps` ".
				"INNER JOIN `llamado_postulacion` `llp` ON (`ps`.`idpostulacion` = `llp`.`idpostulacion`) ".
				"INNER JOIN `llamados` `ll` ON (`llp`.`idllamado` = `ll`.`idllamados`) ".
				"INNER JOIN `grupo` `g` ON (`g`.`idgrupo` = `ps`.`idgrupo`) ".
				"INNER JOIN `persona_comite` `pg` ON (`pg`.`idgrupo` = `g`.`idgrupo`) ".
				"INNER JOIN `persona` `p` ON (`p`.`rut` = `pg`.`rutpersona`) ".
				"WHERE g.numero = ".$ruk." AND ll.idllamados = ".$lmd." AND llp.anio = ".$anio." ".
				"ORDER BY abs(p.rut) asc"; 

$sql = mysqli_query($conn, $postulantes);

$g = mysqli_fetch_row(mysqli_query($conn, $datosGrupo));
$p = mysqli_fetch_row(mysqli_query($conn, $programa));

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel5');

$excel = $reader->load('plantillas/fichafocalizacion.xls');
$excel->setActiveSheetIndex(0);

$excel->getActiveSheet()->setCellValue('D9', $g[0]);
$excel->getActiveSheet()->setCellValue('D10', $g[p]);
$excel->getActiveSheet()->setCellValue('D13', $g[1]);
$excel->getActiveSheet()->setCellValue('D14', mysqli_num_rows($sql));

$i = 23;
$n = 1;

while ($f = mysqli_fetch_array($sql)) {
	# code...
	$excel->getActiveSheet()->setCellValue('A'.$i, $n);
	$excel->getActiveSheet()->setCellValue('B'.$i, strtoupper($f[1]));
	$excel->getActiveSheet()->mergeCells('C'.($i+1).':G'.($i+1));

	$t = array();
	$focalizaciones = '';

	

	if ($f[2] == 1) {
		$t[1]= 'ADULTO MAYOR+';
	}else{
		$t[1]= '';
	}

	if ($f[3] == 1) {
		$t[2]= 'HACINAMIENTO+';
	}else{
		$t[2]= '';
	}

	if ($f[4] == 1) {
		$t[3]= 'DISCAPACIDAD+';
	}else{
		$t[3]= '';
	}

	if ($f[5] == 1) {
		$t[4]= 'ACONDICIONAMIENTO TERMICO+';
	}else{
		$t[4] = '';
	}
	
	if ($f[6] == 1) {
		$t[5]= 'SOCAVONES+';
	}else{
		$t[5]= '';
	}

	if ($f[7] == 1) {
		$t[6]= 'XILOFAGOS+';
	}else{
		$t[6]= '';
	}

	if ($f[8] == 1) {
		$t[7]= 'METROS ORIGINAL+';
	}else{
		$t[7]= '';
	}

	if ($f[9] == 1) {
		$t[8]= 'SEGURIDAD ESTRUCTURAL+';
	}else {
		$t[8]= '';
	}

	if ($f[10] == 1) {
		$t[9]= 'SISTEMA TERMICO+';
	}else{
		$t[9]= '';
	}

	if ($f[11] == 1) {
		$t[10] = 'SISTEMA ELECTRICO+';
	}else{
		$t[10] = '';
	}

	if ($f[12] == 1) {
		$t[11] = 'SANITARIO+';
	}else{
		$t[11] = '';
	}

	if ($f[13] == 1) {
		$t12 = 'ALCANTARILLADO+';
	}else{
		$t[12] = '';
	}

	for ($j=0; $j < count($t); $j++) { 
		# Se guarda las focalizaciones como una cadena
		$focalizaciones .= $t[$j];
	}

	
	$excel->getActiveSheet()->setCellValue('C'.$i, $focalizaciones);



	$excel->getActiveSheet()->getRowDimension($i)->setRowHeight(30.00);

	$focalizaciones = '';

	$i++;
	$n++;
}


$por = ($j*100)/ mysqli_num_rows($sql);

$excel->getActiveSheet()->setCellValue('D15', round($por).'%');

$estiloNomina = new PHPExcel_Style();
$estiloNomina->applyFromArray( array(
	'font' => array(
		'name' => 'Arial',
		'size' => 11,
		'color' => array(
			'rgb' => '000000'
		)		
	),
	'fill' => array(
	  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	  'color' => array(
	        'rgb' => 'FFFFFF'
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

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'B23:G'.($i-1));
$excel->getActiveSheet()->getStyle('B23:G'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->getActiveSheet()->getStyle('B23:G'.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

/*$excel->getActiveSheet()->setCellValue('B'.($i+3), 'Firma Entidad Patrocinante: ');
$excel->getActiveSheet()->setCellValue('D'.($i+3), 'Firma del Representante Legal del Grupo Organizado o Postulante : ');
$excel->getActiveSheet()->setCellValue('B'.($i+6), 'Fecha: '.fechaAl(time()));*/


header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="fichafocalizacion-'.$g[0].'.xls"'); 
header('Cache-Control: max-age=0'); 

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_end_clean();
$writer->save('php://output');

?>