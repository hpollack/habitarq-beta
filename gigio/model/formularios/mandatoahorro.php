<?php 
session_start();
include_once '../../lib/php/libphp.php';

date_default_timezone_set("America/Santiago");
set_time_limit(60);

$rutus = $_SESSION['rut'];
if(!$rutus) {
	echo "No puede ver esta página";
	header("location: ".url()."login.php");
	exit();
}

$conn = conectar();

$rut = $_GET['r'];

$string = "select distinct concat(p.rut,'-',p.dv) as rut, concat(p.nombres,' ',p.paterno,' ',p.materno), ".
		  "cp.ncuenta, g.nombre from persona as p ".
		  "inner join cuenta_persona as cp on cp.rut_titular = p.rut ".
		  "inner join persona_comite as pc on pc.rutpersona = p.rut ".
		  "inner join grupo as g on g.idgrupo = pc.idgrupo ".
		  "inner join persona_ficha as pf on pf.rutpersona = p.rut ".
		  "inner join frh as f on f.nficha = pf.nficha ".
		  "inner join lista_postulantes as lp on lp.rutpostulante = p.rut ".
		  "inner join llamado_postulacion ll on ll.idllamado_postulacion = lp.idllamado_postulacion ".
		  "inner join llamados as l on l.idllamados = ll.idllamado ".
		  "where p.rut = '".$rut."'";

$sql = mysqli_query($conn, $string);

if (mysqli_num_rows($sql) > 0) {
	
	require_once '../../lib/php/phpword/Autoloader.php';
	\PhpOffice\PhpWord\Autoloader::register();

	$word = new \PhpOffice\PhpWord\TemplateProcessor('plantillas/mandato.docx');

	if ($f = mysqli_fetch_array($sql)) {
		# code...
		$word->setValue('nombre', strtoupper($f[1]));
		$word->setValue('rut', $f[0]);
		$word->setValue('comite', $f[3]);
		$word->setValue('ncuenta', $f[2]);
		$word->setValue('fecha', fechaAl(time()));
	}

	$word->saveAs('plantillas/results/Mandato de Ahorro '.$f[1].'.docx');
	header("Content-Disposition: attachment; filename=Mandato de Ahorro ".$f[1].".docx; charset=iso-8859-1");

	echo file_get_contents('plantillas/results/Mandato de Ahorro '.$f[1].'.docx');
}else{
	echo "Error";
}


?>