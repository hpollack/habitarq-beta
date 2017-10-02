<?php 

//Cambia estado de persona en el comite a eliminado. 
//Por integridad estos datos no son borrados.
//Además se agrega un motivo el cuál puede ser consultado -modulo pendiente-

session_start();

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

$rut = $_POST['crut'];
$idg = $_POST['idg'];
$mot = $_POST['mot'];
$obs = mysqli_real_escape_string($conn, $_POST['obs']);

//Sentencias para la actualización. La primera cambia el estado del miembro del comite a "Eliminado". 
//A su vez la segunda ingresa el motivo de la eliminación
$string = "update persona_comite set estado = 'Eliminado' where rutpersona = '".$rut."';";
$string .= "insert into historial_eliminados_comite(idhistorial, rut_socio, idcomite, idmotivo, observacion) ".
		   "values(".obtenerid("historial_eliminados_comite","idhistorial").", '".$rut."', ".$idg.", ".$mot.", '".$obs."')";

//Se ejecutan ambas sentencias con la opción multiquery que trae la nueva librería de mysql para php	   
$sql = mysqli_multi_query($conn, $string);

if($sql){

	#Mensaje de éxtio
	echo "1";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	       "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'delete', ".time().");";

	mysqli_query($conn, $log);
}else{

	#Mensaje de error;
	echo "0";
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	  	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'error deleting', ".time().");";

	mysqli_query($conn, $log);
}

mysqli_close($conn);

 ?>