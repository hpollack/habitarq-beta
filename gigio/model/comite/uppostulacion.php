<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();

$pos  = $_POST['pos'];
$idg  = $_POST['idg'];
$item = $_POST['item'];
$fi   = fechamy($_POST['fi']);
$ds   = $_POST['ds'];
$con  = $_POST['con'];

$fecha_final = quitaSabadoyDomingo($fi, $ds);

$string  = "update postulaciones set item_postulacion = ".$item.", fecha_inicio = ".strtotime($fi).", ".
		   "fecha_final = ".strtotime($fecha_final).", dias = ".$ds." where idpostulacion = ".$pos.";";
$string .= "update profesional_postulacion set rutprof ='".$con."' where idpostulacion = ".$pos.";";

echo $string;
exit();

$sql = mysqli_multi_query($conn, $string);

if ($sql) {
	echo "1";
}else {
	echo "0";
	exit();
}

mysqli_free_result($sql);
mysqli_close($conn);

?>