<?php
session_start();

date_default_timezone_set("America/Santiago");

include_once '../../lib/php/libphp.php';

set_time_limit(60);

$rutus = $_SESSION['rut'];
if(!$rutus) {
	echo "No puede ver esta página";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$rutpostulante = $_GET['r'];

//echo $rutpostulante; exit();


$postulante = "select concat(`p`.`rut`, '-', `p`.`dv`) AS `rut`, ".
		  "concat(`p`.`nombres`, ' ', `p`.`paterno`, ' ', `p`.`materno`) AS `nombre`, " .
		  "concat(`d`.`calle`, ' N° ', `d`.`numero`) AS `direccion`, ".
		  "c.`COMUNA_NOMBRE`, d.localidad ".
		  "from `persona` `p` ".
		  "INNER JOIN `direccion` `d` ON (`p`.`rut` = `d`.`rutpersona`) ".
		  "INNER JOIN `comuna` `c` ON (`d`.`idcomuna` = `c`.`COMUNA_ID`) ".
		  "WHERE p.rut = '".$rutpostulante."'";

//echo $postulante; exit();

$proyecto = "select  `g`.`nombre`, e.nombre ".
			"FROM  `grupo` `g` ".
			"INNER JOIN `persona_comite` `pg` ON (`g`.`idgrupo` = `pg`.`idgrupo`) ".
			"INNER JOIN `egis` `e` ON (`g`.`idegis` = `e`.`idegis`) ".
			"WHERE pg.rutpersona = '".$rutpostulante."' AND pg.`estado` = 'Postulante'";

 					  

$sql = mysqli_query($conn, $postulante);


if (mysqli_num_rows($sql) > 0) {
	# Si el postulante existe...
	require_once '../../lib/php/phpword/Autoloader.php';
	\PhpOffice\PhpWord\Autoloader::register();

	$word = new \PhpOffice\PhpWord\TemplateProcessor('plantillas/djurada.docx');
	$fecha = fechaAl(time());

	$p = mysqli_fetch_row(mysqli_query($conn, $proyecto));	

	if ($f = mysqli_fetch_array($sql)) {
		# Si vienen una fila...
		$word->setValue('rut', $f[0]);
		$word->setValue('nombre', $f[1]);
		$word->setValue('direccion', $f[2]);
		$word->setValue('comuna', $f[3]);
		$word->setValue('localidad', $f[4]);
		$word->setValue('egis', $p[1]);
		$word->setValue('titulo', $p[0]);
		$word->setValue('fecha', $fecha);
		
	}

	$word->saveAs('plantillas/results/djurada '.$f[1].'.docx');
	header("Content-Disposition: attachment; filename=djurada ".$f[1].".docx; charset=iso-8859-1");

	echo file_get_contents('plantillas/results/djurada '.$f[1].'.docx');

}else{

	echo "No se pudo generar el documento.";
}


?>