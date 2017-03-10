<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$tip = $_POST['tip'];
$html = "";

if (!isset($tip)) {
	echo "No hay id";
	exit();
}

$str = "select iditem_postulacion, item_postulacion from item_postulacion where idtipopostulacion = ".$tip."";
$sql = mysqli_query($conn, $str);

$html.= "<option value='0'>Escoja Tipo de Postulación</option>";

while ($f = mysqli_fetch_array($sql)) {
	$html .= "<option value='".$f[0]."'>".$f[1]."</option>";
}

mysqli_free_result($sql);
mysqli_close($conn);

echo $html;

?>