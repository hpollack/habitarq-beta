<?php 
/*
==========================================================
Eliminacion Lógica de personas
==========================================================

Esta eliminación cambia el estado de activo (1) a inactivo (0).
Cuando ocurre las búsquedas no incluyen a la persona desafectada

Se incluye en eta actualizacion, el cambio de estado en el comité - de existir-
*/

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
$rut = explode("-", $_GET['r'], -1);

$string = "update persona set estado = 0 where rut ='".$rut[0]."'";

$string1 = "select estado from persona_comite where rutpersona = '".$rut."'";

$string2 = "update persona_comite set estado = 'Eliminado' where rutpersona = '".$rut[0]."';";

$sql = mysqli_query($conn, $string);
if($sql){

	$es = mysqli_fetch_row(mysqli_query($conn, $string1));
	
	if ($es[0]!=null) {
		# Si existe, se cambia el estado.
		$sql2 = mysqli_query($conn, $string2);
	}

	echo "1";
}else{
	
	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/listpersona.php', 'del', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);

?>