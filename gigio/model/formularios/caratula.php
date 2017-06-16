<?php 
session_start();

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: login.php");
	exit();
}

include_once '../../lib/php/libphp.php';
include '../../lib/php/phpexcel/Classes/PHPExcel.php';
include '../../lib/php/phpexcel/Classes/PHPExcel/IOFactory.php';

date_default_timezone_set("America/Santiago");

$conn = conectar();

$ruk = mysqli_real_escape_string($conn, $_POST['ruk']);
$lmd = $_POST['lmd'];
$anio = $_POST['canio'];


/*$ruk = 2000;
$lmd = 1;*/

//check
$org = (isset($_POST['org'])) ? "si" : "no";
$cnv = (isset($_POST['cnv'])) ? "si" : "no";
$cnt = (isset($_POST['cnt'])) ? "si" : "no";
$reg = (isset($_POST['reg'])) ? "si" : "no";

$fecha = time(); //Si se debe cambiar por alguna guardada en la base de datos, se usa esta variable


//$table = "";

$datosGrupo = "select g.nombre, g.numero from grupo as g where g.numero = ".$ruk."";

$datosEgis  = "select e.rut, e.nombre, e.direccion, c.COMUNA_NOMBRE, r.REGION_NOMBRE, e.fono, e.correo from egis as e ".
			  "inner join grupo as g on g.idegis = e.idegis ".
			  "inner join comuna as c on c.COMUNA_ID = e.idcomuna ".
			  "inner join provincia as p on p.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
			  "inner join region as r on r.REGION_ID = p.PROVINCIA_REGION_ID ".
			  "where g.numero = ".$ruk."";			  

$datosProf  = "select concat(pf.rutprof,'-',pf.dv) as rutprof, ".
			  "concat(pf.nombres,' ',pf.apellidos) as nombre, ".
			  "pf.direccion, c.COMUNA_NOMBRE, r.REGION_NOMBRE, pf.telefono, pf.correo ".			  
			  "from profesionales as pf ".
			  "inner join profesional_postulacion as ps on ps.rutprof = pf.rutprof ".
			  "inner join comuna as c on c.COMUNA_ID = pf.idcomuna ".
			  "inner join provincia as pv on pv.PROVINCIA_ID = c.COMUNA_PROVINCIA_ID ".
			  "inner join region as r on r.REGION_ID = pv.PROVINCIA_REGION_ID ".			  
			  "inner join postulaciones as pp on pp.idpostulacion = ps.idpostulacion ".
			  "inner join grupo as g on g.idgrupo = pp.idgrupo ".
			  "where g.numero = ".$ruk."";		  

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

$numpostulantes = "select count(*) from lista_postulantes as lp ".
				  "inner join postulaciones as ps on ps.idpostulacion = lp.idpostulacion ".
				  "inner join llamado_postulacion as pl on pl.idllamado_postulacion = lp.idllamado_postulacion ".
				  "inner join llamados as l on l.idllamados = pl.idllamado ".
				  "inner join grupo as g on g.idgrupo = ps.idgrupo ".
				  "where g.numero = ".$ruk." and l.idllamados = ".$lmd." and pl.anio =".$anio."";

$ahorrouf =  "select sum(ahorro) as totaluf ".
			 "FROM lista_postulantes AS lp ".
			 "INNER JOIN cuenta_persona AS cp ON lp.rutpostulante = cp.rut_titular ".
			 "INNER JOIN cuenta AS c ON cp.ncuenta = c.ncuenta ".
			 "INNER JOIN llamado_postulacion AS pl ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
			 "INNER JOIN postulaciones AS p ON pl.idpostulacion = p.idpostulacion ".
			 "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
			 "where g.numero = ".$ruk." and pl.idllamado = ".$lmd." and pl.anio = ".$anio."";

$subsidiouf = "select sum(subsidio) as totaluf ".
			 "FROM lista_postulantes AS lp ".
			 "INNER JOIN cuenta_persona AS cp ON lp.rutpostulante = cp.rut_titular ".
			 "INNER JOIN cuenta AS c ON cp.ncuenta = c.ncuenta ".
			 "INNER JOIN llamado_postulacion AS pl ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
			 "INNER JOIN postulaciones AS p ON pl.idpostulacion = p.idpostulacion ".
			 "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
			 "where g.numero = ".$ruk." and pl.idllamado = ".$lmd." and pl.anio = ".$anio."";

$totaluf =   "select sum(total) as totaluf ".
			 "FROM lista_postulantes AS lp ".
			 "INNER JOIN cuenta_persona AS cp ON lp.rutpostulante = cp.rut_titular ".
			 "INNER JOIN cuenta AS c ON cp.ncuenta = c.ncuenta ".
			 "INNER JOIN llamado_postulacion AS pl ON pl.idllamado_postulacion = lp.idllamado_postulacion ".
			 "INNER JOIN postulaciones AS p ON pl.idpostulacion = p.idpostulacion ".
			 "INNER JOIN grupo AS g ON p.idgrupo = g.idgrupo ".
			 "where g.numero = ".$ruk." and pl.idllamado = ".$lmd." and pl.anio = ".$anio."";

$programa = "select concat(tt.titulo,' (',ip.item_postulacion,')') as programa ".
    		"from postulaciones as p ".
    		"inner join grupo as g on p.idgrupo = g.idgrupo ".
    		"inner join profesional_postulacion as pp on pp.idpostulacion = p.idpostulacion ".
    		"inner join item_postulacion as ip on p.item_postulacion = ip.iditem_postulacion ".
    		"inner join tipopostulacion as tp on ip.idtipopostulacion = tp.idtipopostulacion ".
    		"inner join titulo_postulacion as tt on tt.idtitulo_postulacion = tp.idtitulo ".
    		"inner join llamado_postulacion lp on lp.idpostulacion = p.idpostulacion ".
    		"where g.numero = ".$ruk." and lp.idllamado = ".$lmd." and lp.anio =".$anio."";


$g = mysqli_fetch_row(mysqli_query($conn, $datosGrupo));
$p = mysqli_fetch_row(mysqli_query($conn, $datosPresi));
$pr = mysqli_fetch_row(mysqli_query($conn, $datosProf));
$e = mysqli_fetch_row(mysqli_query($conn, $datosEgis));
$a = mysqli_fetch_row(mysqli_query($conn, $ahorrouf));
$s = mysqli_fetch_row(mysqli_query($conn, $subsidiouf));
$t = mysqli_fetch_row(mysqli_query($conn, $totaluf));
$pg = mysqli_fetch_row(mysqli_query($conn, $programa));
$lp = mysqli_fetch_row(mysqli_query($conn, $numpostulantes));

$excel = new PHPExcel();
$reader = PHPExcel_IOFactory::createReader('Excel5');

$excel = $reader->load('plantillas/caratula.xls');

$excel->setActiveSheetIndex(0);


$excel->getActiveSheet()->SetCellValue('B6', $pg[0]);
$excel->getActiveSheet()->SetCellValue('C9', $g[0]);
$excel->getActiveSheet()->setCellValue('H9', $g[1]);
$excel->getActiveSheet()->SetCellValue('C11', ucwords($p[0]));
$excel->getActiveSheet()->SetCellValue('I11', $org);
$excel->getActiveSheet()->SetCellValue('C12', ucwords($p[1]));
$excel->getActiveSheet()->SetCellValue('C13', ucwords($p[2]));
$excel->getActiveSheet()->SetCellValue('C14', ucwords($p[3]));
$excel->getActiveSheet()->SetCellValue('H12', $p[6]);
$excel->getActiveSheet()->SetCellValue('H13', $p[7]);

if ($p[5] != 1) {
	$tipo = "+569".$p[4];
}else{
	$tipo = $p[4];
}

$excel->getActiveSheet()->SetCellValue('H14',$tipo);

//Datos Egis
$excel->getActiveSheet()->SetCellValue('C16',$e[1]);
$excel->getActiveSheet()->SetCellValue('C17',$e[2]);
$excel->getActiveSheet()->SetCellValue('C18',$e[3]);
$excel->getActiveSheet()->SetCellValue('F18',$e[4]);
$excel->getActiveSheet()->SetCellValue('I16',$cnv);
$excel->getActiveSheet()->SetCellValue('C19',$e[5]);
$excel->getActiveSheet()->SetCellValue('H18',$e[0]);
$excel->getActiveSheet()->SetCellValue('H19',$e[6]);

//Datos constructor
$excel->getActiveSheet()->SetCellValue('C21', $pr[1]);
$excel->getActiveSheet()->SetCellValue('C22', $pr[2]);
$excel->getActiveSheet()->SetCellValue('C23', $pr[3]);
$excel->getActiveSheet()->SetCellValue('C25', $pr[4]);
$excel->getActiveSheet()->setCellValue('C24', $pr[5]);
$excel->getActiveSheet()->setCellValue('I21', $cnt);
$excel->getActiveSheet()->setCellValue('I22', $reg);
$excel->getActiveSheet()->setCellValue('H23', $pr[0]);
$excel->getActiveSheet()->SetCellValue('H24', $pr[6]);

//Datos Numéricos
$excel->getActiveSheet()->setCellValue('H25', $lp[0]);
$excel->getActiveSheet()->setCellValue('H27', $t[0]);
$excel->getActiveSheet()->setCellValue('H31', $s[0]);
$excel->getActiveSheet()->setCellValue('H33', $a[0]);

$excel->getActiveSheet()->setCellValue('B50', fechaAl($fecha));

mysqli_close($conn);

header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="caratula '.$g[0].'.xls"'); 
header('Cache-Control: max-age=0'); 

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_end_clean();
$writer->save('php://output');

?>
