<?php 
session_start();

date_default_timezone_set("America/Santiago");

set_time_limit(120);

include_once '../../lib/php/libphp.php';

set_time_limit(60);

$rutus = $_SESSION['rut'];
if(!$rutus) {
	echo "No puede ver esta página";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$ruk = mysqli_real_escape_string($conn, $_POST['ruk1']);
$lmd = $_POST['llmd'];
$anio = $_POST['ganio'];

// Datos Nomina
$string =  "select distinct
			p.paterno, p.materno, p.nombres,
			p.rut, p.dv,
			concat(d.calle,' N° ',d.numero) as direccion,
			f.puntaje, v.rol, ec.estado,
			case f.discapacidad
				when 1 then 'DISC' else 
				case f.adultomayor
					when 1 then 'AM' else ''
				end 
			end as focalizacion,
			v.anio,
			(select sum(n.metros) from mts as n where n.idestado_vivienda = 1 and n.rol = v.rol) as mp1,
			(select sum(n.metros) from mts as n where n.idestado_vivienda = 2 and n.rol = v.rol) as mp2,
			v.superficie,
			cp.ncuenta as cuenta,
			v.fojas
			from
			persona_comite as pc
			inner join persona as p on p.rut = pc.rutpersona
			inner join direccion as d on d.rutpersona = p.rut
			inner join persona_vivienda as pv on pv.rut = p.rut
			inner join vivienda as v on v.rol = pv.rol
			inner join persona_ficha as pf on pf.rutpersona = p.rut
			inner join frh as f on f.nficha = pf.nficha
			inner join estado_civil as ec on ec.idestadocivil = f.idestadocivil
			inner join cuenta_persona as cp on cp.rut_titular = p.rut
			inner join lista_postulantes as lp on lp.rutpostulante = p.rut
			inner join llamado_postulacion as llp on llp.idllamado_postulacion = lp.idllamado_postulacion
			inner join postulaciones as ps on ps.idpostulacion = llp.idpostulacion
			inner join grupo as g on g.idgrupo = ps.idgrupo			
			where g.numero = ".$ruk." and llp.idllamado = ".$lmd." and llp.anio = ".$anio." and pc.estado = 'Postulante'";

$datosPresi = "select concat(p.nombres,' ',p.paterno,' ',p.materno) as nombre, ".
			  "concat(d.calle,' N° ',d.numero) as direccion, " .
			  "c.COMUNA_NOMBRE, r.REGION_NOMBRE, f.numero, f.tipo, concat(p.rut,'-', p.dv) as rut, ".
			  "p.correo ".
			  "from persona as p ".
			  "inner join persona_comite as pc on pc.rutpersona = p.rut ".
			  "inner join direccion as d on d.rutpersona = p.rut ".
			  "inner join fono as f on f.rutpersona = p.rut ".
			  "inner join comuna as c on c.COMUNA_ID = d.idcomuna ".
			  "inner join provincia as pv on pv.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
			  "inner join region as r on r.REGION_ID = pv.PROVINCIA_REGION_ID ".
			  "inner join grupo as g on g.idgrupo = pc.idgrupo ".
			  "where g.numero = ".$ruk." and pc.idcargo = 2";


$sql = mysqli_query($conn, $string);

$p = mysqli_fetch_row(mysqli_query($conn, $datosPresi));

$g = mysqli_fetch_row(mysqli_query($conn, "select nombre, localidad from grupo where numero = ".$ruk.""));

include '../../lib/php/phpexcel/Classes/PHPExcel.php';
include '../../lib/php/phpexcel/Classes/PHPExcel/IOFactory.php';

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel2007');

$excel = $reader->load('plantillas/nomina-comite.xlsx');

$excel->setActiveSheetIndex(0);

//Titulo 
$excel->getActiveSheet()->setCellValue('C1', 'NÓMINA DE POSTULANTES '.$g[0]);

//Nombe del comite.
$excel->getActiveSheet()->setCellValue('C2', $g[0]);

//Localidad o sector
$excel->getActiveSheet()->setCellValue('C5', $g[1]);

// Representante Legal (de existir en la base de datos, si no queda vacio)
$excel->getActiveSheet()->setCellValue('C3', $p[0]);

$i = 9; // Fila donde comienza la iteración

$n = 1; // variable de control de numero de filas

$total = 0;

while ($f = mysqli_fetch_array($sql)) {
	# Filas  a escribirse.
	$excel->getActiveSheet()->setCellValue('A'.$i, $n);
	$excel->getActiveSheet()->setCellValue('B'.$i, $f[0]);
	$excel->getActiveSheet()->setCellValue('C'.$i, $f[1]);
	$excel->getActiveSheet()->setCellValue('D'.$i, $f[2]);
	$excel->getActiveSheet()->setCellValue('E'.$i, $f[3]);
	$excel->getActiveSheet()->setCellValue('F'.$i, $f[4]);
	$excel->getActiveSheet()->setCellValue('G'.$i, $f[5]);
	$excel->getActiveSheet()->setCellValue('H'.$i, $f[6]);
	$excel->getActiveSheet()->setCellValue('I'.$i, $f[7]);
	$excel->getActiveSheet()->setCellValue('J'.$i, $f[8]);
	$excel->getActiveSheet()->setCellValue('K'.$i, $f[9]);
	$excel->getActiveSheet()->setCellValue('L'.$i, $f[10]);
	$excel->getActiveSheet()->setCellValue('M'.$i, $f[11]);
	$excel->getActiveSheet()->setCellValue('N'.$i, $f[12]);
	$excel->getActiveSheet()->setCellValue('P'.$i, $f[13]);
	$excel->getActiveSheet()->setCellValue('Q'.$i, $f[14]);
	$excel->getActiveSheet()->setCellValue('R'.$i, $f[15]);

	$suma += $f[6];

	$i++;
	$n++;

	$total++;
}

$excel->getActiveSheet()->setCellValue('C6', $total);
$excel->getActiveSheet()->setCellValue('G'.($i+1), 'PROMEDIO GRUPAL');

$prom = $suma/$i;

$excel->getActiveSheet()->setCellValue('H'.($i+1), (float)$prom);

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

$excel->getActiveSheet()->setSharedStyle($estiloNomina, 'A9:T'.($i-1));
$excel->getActiveSheet()->getStyle('A9:T'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

mysqli_close($conn);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="nomina-comite-'.$g[0].'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
ob_end_clean();
$writer->save('php://output');
exit;
?>