<?php
/**
 * =============================================================
 * COMBO DE BUSQUEDA DE PROVINCIA.
 * =============================================================
 * 
 * Carga los datos de las provincias existentes.
 * Dependiente del identificador de la region,
 * extrae solo las que le corresponden a esta.
 * 
 * @param integer $id: ID de la provincia
 * @return html $html: las opciones del combo.
 * 
 **/
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

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