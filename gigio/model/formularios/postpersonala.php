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

$rut = $_GET['r'];

$postulante = "select distinct concat(p.rut,'-',p.dv) AS rut, ".
			  "concat(p.nombres,' ',p.paterno,' ',p.materno) AS nombre, ".
			  "d.calle, d.numero, c.COMUNA_NOMBRE, r.REGION_NOMBRE, d.localidad ".
			  "FROM persona AS p ".
			  "INNER JOIN direccion AS d ON p.rut = d.rutpersona ".
			  "INNER JOIN comuna AS c ON d.idcomuna = c.COMUNA_ID ".
			  "INNER JOIN provincia AS prv ON c.COMUNA_PROVINCIA_ID = prv.PROVINCIA_ID ".
			  "INNER JOIN region AS r ON prv.PROVINCIA_REGION_ID = r.REGION_ID ".
			  "WHERE p.rut = '".$rut."' and p.estado = 1";			  

$programa = "select ttps.titulo, ips.item_postulacion, g.numero, g.nombre from ".
			"persona_comite as pc ".
			"inner join postulaciones as ps on pc.idgrupo = ps.idgrupo ".
			"inner join item_postulacion as ips on ips.iditem_postulacion = ps.item_postulacion ".
			"inner join tipopostulacion as tps on tps.idtipopostulacion = ips.idtipopostulacion ".
			"inner join titulo_postulacion as ttps on ttps.idtitulo_postulacion = tps.idtitulo ".
			"inner join grupo as g on g.idgrupo = ps.idgrupo ".
			"where pc.rutpersona = '".$rut."' and pc.estado = 'Postulante'";

$cuenta  = 	"select c.ncuenta, c.ahorro, c.subsidio, c.total from cuenta as c ".
			"inner join cuenta_persona as cp on cp.ncuenta = c.ncuenta ".
			"where cp.rut_titular = '".$rut."' ";

$metros   = "select sum(m.metros) from vivienda as v ".
			"inner join mts as m on m.rol = v.rol ".
			"inner join persona_vivienda as pv on pv.rol = v.rol ".
			"where pv.rut = '".$rut."'";
			

$p = mysqli_fetch_row(mysqli_query($conn, $postulante));
$t = mysqli_fetch_row(mysqli_query($conn, $programa));
$c = mysqli_fetch_row(mysqli_query($conn, $cuenta));
$m = mysqli_fetch_row(mysqli_query($conn, $metros));

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel5');

$excel = $reader->load('plantillas/fichapostpersonal.xls');

$excel->setActiveSheetIndex(0);

$excel->getActiveSheet()->setCellValue('B6', strtoupper($t[0]).' ('.strtoupper($t[1]).')');

$excel->getActiveSheet()->setCellValue('D9', $p[1]);
$excel->getActiveSheet()->setCellValue('H9', $p[0]);
$excel->getActiveSheet()->setCellValue('D11', $p[2]);
$excel->getActiveSheet()->setCellValue('H11', $p[3]);
$excel->getActiveSheet()->setCellValue('D12', $p[4]);
$excel->getActiveSheet()->setCellValue('H12', $p[5]);
$excel->getActiveSheet()->setCellValue('D13', $p[6]);

// Segunda seccion.
$excel->getActiveSheet()->setCellValue('D15', 'Nombre: COMITÉ DE '. $t[3]);
$excel->getActiveSheet()->setCellValue('H15', $t[2]);

//Tercera Seccion
$excel->getActiveSheet()->setCellValue('D23', $c[0]);
$excel->getActiveSheet()->setCellValue('H23', $p[0]);
$excel->getActiveSheet()->setCellValue('D24', $p[1]);
$excel->getActiveSheet()->setCellValue('H25', $c[1]);

if ($m[0] < 12) {

	$celda = 'E31';
}else if (($m[0] >= 12) && ($m[0] < 28)) {

	$celda = 'E32';
}else {

	$celda = 'E33';
}

$excel->getActiveSheet()->setCellValue($celda, $c[2]);

//Fecha del día que se emite el documento.
$excel->getActiveSheet()->setCellValue('B49', 'Fecha '.date("d-m-Y", time()));



header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="ficha-postulacion-personal-'.$p[0].'.xls"'); 
header('Cache-Control: max-age=0'); 

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_end_clean();
$writer->save('php://output');
?>