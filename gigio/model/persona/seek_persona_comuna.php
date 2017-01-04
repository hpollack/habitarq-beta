<?php
session_start();
include_once '../../lib/php/libphp.php';

$conn = conectar();
$id = $_POST['idpr'];
$html = "";
if(!isset($id)){
	echo "No hay id";
	exit();
}
$str = "SELECT COMUNA_ID, COMUNA_NOMBRE FROM comuna WHERE COMUNA_PROVINCIA_ID = ".$id.";";
			
$sql_pr = mysqli_query($conn, $str);
$html .= '<option value="0">Seleccione una comuna</option>';
while($rpr = mysqli_fetch_assoc($sql_pr)){
	$html .= "<option value='".$rpr['COMUNA_ID']."'>".$rpr['COMUNA_NOMBRE']."</option>";
}
mysqli_free_result($sql_pr);
mysqli_close($conn);
echo $html;
?>