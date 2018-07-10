<?php 
session_start();
date_default_timezone_set("America/Santiago");
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

$pos  = $_POST['pos'];
$idg  = $_POST['idg'];
$item = $_POST['item'];
$fi   = fechamy($_POST['fi']);
$ds   = $_POST['ds'];
$con  = $_POST['con'];
$lmd  = $_POST['lmd'];
$anio = $_POST['anl'];

$fecha_final = fechaFinal($fi, $ds);

$llamado = mysqli_fetch_row(mysqli_query($conn, "select idllamado, anio, idllamado_postulacion from llamado_postulacion where idpostulacion = ".$pos." and idllamado = ".$lmd.""));

$strllamado = "";

if ($llamado[2]) {
	
	//Si el id ya existe
	$strllamado = "update llamado_postulacion set llamado = ".$lmd.", anio = ".$anio." where idpostulacion = ".$pos.";";
}else if (($llamado[0] == $lmd) && ($llamado[1] == $anio)) {
	
	//No presenta cambios.
	$strllamado = "update llamado_postulacion set llamado = ".$lmd.", anio = ".$anio." where idpostulacion = ".$pos.";";
}else if ($llamado[0] == $lmd) {
	
	//Se agrega nuevo llamado pero con año distinto
	$strllamado = "insert into llamado_postulacion(idllamado_postulacion, idpostulacion, idllamado, anio) ".
				  "values(".obtenerid("llamado_postulacion", "idllamado_postulacion").", ".$pos.", ".$lmd.", ".$anio.");";
}else if ($llamado[1] == $anio) {
	
	//Se agrega nuevo llamado con el mismo año pero distinto al existente.
	$strllamado = "insert into llamado_postulacion(idllamado_postulacion, idpostulacion, idllamado, anio) ".
				  "values(".obtenerid("llamado_postulacion", "idllamado_postulacion").", ".$pos.", ".$lmd.", ".$anio.");";
}else {

	//Si ambos son distintos, es un nuevo llamado.
	$strllamado = "insert into llamado_postulacion(idllamado_postulacion, idpostulacion, idllamado, anio) ".
				  "values(".obtenerid("llamado_postulacion", "idllamado_postulacion").", ".$pos.", ".$lmd.", ".$anio.");";
}

$string  = "update postulaciones set item_postulacion = ".$item.", fecha_inicio = ".strtotime($fi).", ".
		   "fecha_final = ".strtotime($fecha_final).", dias = ".$ds." where idpostulacion = ".$pos.";";
$string .= $strllamado.		   
$string .= "update profesional_postulacion set rutprof ='".$con."' where idpostulacion = ".$pos.";";

$sql = mysqli_multi_query($conn, $string);

if ($sql) {
	
	echo "1";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/grupal.php', 'update', ".time().");";

	mysqli_query($conn, $log);
}else {

	echo mysqli_error($conn);

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/grupal.php', 'error updating', ".time().");";

	mysqli_query($conn, $log);
}
	exit();

	

//mysqli_free_result($sql);
mysqli_close($conn);

?>