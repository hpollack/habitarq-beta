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

$cmt  = $_POST['mruk'];
$lmd  = $_POST['mlmd'];
$anio = $_POST['manio'];

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
		  "where g.numero = ".$cmt." and l.idllamados = ".$lmd." and ll.anio = ".$anio."";

$sql = mysqli_query($conn, $string);

if (mysqli_num_rows($sql) > 0) {
	
	require_once '../../lib/php/phpword/Autoloader.php';
	\PhpOffice\PhpWord\Autoloader::register();

	$word = new \PhpOffice\PhpWord\TemplateProcessor('plantillas/mandato.docx');

	

}

?>