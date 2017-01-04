<?php
session_start();
include_once '../../lib/php/libphp.php';

$conn = conectar();
if(!$conn){
	echo mysqli_connect_errno();
	exit();
}
$id = $_POST['idreg'];
$html = "";
$str = "SELECT PROVINCIA_ID, PROVINCIA_NOMBRE FROM provincia WHERE PROVINCIA_REGION_ID = ".$id."";

$sql_reg = mysqli_query($conn, $str);

$html.= "<option value='0'>Seleccione una provincia</option>";
while($rreg = mysqli_fetch_assoc($sql_reg)){
	$html .= "<option value='".$rreg['PROVINCIA_ID']."'>".$rreg['PROVINCIA_NOMBRE']."</option>";
}
mysqli_free_result($sql_reg);
mysqli_close($conn);
echo $html;			
?>