<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

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