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

$conn = conectar();

$cmt = $_POST['cmt'];
$html = "";

if (!isset($cmt)) {
	echo "No hay id";
	exit();
}

$str = "select lp.idllamado_postulacion, concat(g.nombre,'. Postulacion ',p.idpostulacion,'. ', l.llamados,', año ', lp.anio) ".
	   "from postulaciones as p ".
	   "inner join grupo as g on p.idgrupo = g.idgrupo ".
	   "inner join llamado_postulacion as lp on lp.idpostulacion = p.idpostulacion ".
	   "inner join llamados  as l on lp.idllamado = l.idllamados ".
	   "where g.idgrupo = ".$cmt."";

$sql = mysqli_query($conn, $str);

$html.= "<option value='0'>Escoja Llamado</option>";

while ($f = mysqli_fetch_array($sql)) {
	$html .= "<option value='".$f[0]."'>".$f[1]."</option>";
}

mysqli_free_result($sql);
mysqli_close($conn);

echo $html;
 ?>