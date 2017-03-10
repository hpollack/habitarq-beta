<?php 
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();

$idg  = $_POST['idg'];
$item = $_POST['item'];
$fi   = fechamy($_POST['fi']);
$ds   = $_POST['ds'];
$con  = $_POST['con'];

$postulantes = mysqli_fetch_array(mysqli_query($conn, "select count(*) from persona_comite where idgrupo = ".$idg.""));
if ($postulaciones[0] == 0) {
	echo "2";
	exit();
}

$fecha_final = quitaSabadoyDomingo($fi, $ds);


$id = obtenerid("postulaciones", "idpostulacion");

$string  = "insert into postulaciones(idpostulacion, idgrupo, item_postulacion, fecha_inicio, fecha_final, dias)".
           " values(".$id.", ".$idg.", ".$item.", ".strtotime($fi).", ".strtotime($fecha_final).", ".$ds.");";
$string .= "insert into profesional_postulacion (idprofesional_postulacion, rutprof, idpostulacion) ".
		   "values(".obtenerid("profesional_postulacion", "idprofesional_postulacion").", '".$con."', ".$id.");";

$sql = mysqli_multi_query($conn, $string);

if ($sql) {	
	echo "1";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/grupal.php', 'add', ".time().");";
	mysqli_query($conn, $log);

}else {
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/grupal.php', 'error add', ".time().");";
	mysqli_query($conn, $log);
	exit();
}


mysqli_close($conn);

?>