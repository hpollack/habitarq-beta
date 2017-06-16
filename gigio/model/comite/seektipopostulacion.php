<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

$tit = $_POST['tit'];
$html = "";

if (!isset($tit)) {
	echo "No hay id";
	exit();
}

$str = "select idtipopostulacion, nombre from tipopostulacion where idtitulo = ".$tit."";
$sql = mysqli_query($conn, $str);

$html.= "<option value='0'>Escoja Tipo de Postulación</option>";

while ($f = mysqli_fetch_array($sql)) {
	$html .= "<option value='".$f[0]."'>".$f[1]."</option>";
}

mysqli_free_result($sql);
mysqli_close($conn);

echo $html;

?>