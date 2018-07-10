<?php 
/**
 * =========================================================================
 *  INGRESO DE DATOS VIVIENDA
 * =========================================================================
 * 
 * Script para el ingreso de datos de vivienda del postulante.
 * Afecta varias tablas asociadas estas son:
 *  - Vivienda
 *  - persona_vivienda: tabla asociada a la persona
 *  - metros: metros de la vivienda dependiendo del estado (1 si es original y 2 si es ampliacion)
 *  - vivienda_certificados : los datos de certificados de la vivienda (de 1 a 4) opcionales
 * 
 * @author Hermann Pollack
 * @version 1.1: se agregó la funcionalidad multiquery de la libreria MySQLi
 * @version 1.2: Se corrigió el ingreso de certificaciones y metros ya que al saltarse algunos,
 * la sentencia era mal procesada.
 * @version 1.3: Se valida que solo un piso, sea agregado para ampliación.
**/

session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$rol = mysqli_real_escape_string($conn, $_POST['rol']);
$foj = mysqli_real_escape_string($conn, $_POST['foj']);

# el Numero no puede entregar un valor nulo. 
# Se agregó una condicion implícita que devuelve 0 si no viene nada en el campo
$num = (mysqli_real_escape_string($conn, $_POST['num'])=="") ? 0 : mysqli_real_escape_string($conn, $_POST['num']);
$cv  = mysqli_real_escape_string($conn, $_POST['cv']);
$ar  = mysqli_real_escape_string($conn, $_POST['ar']);
$tv  = mysqli_real_escape_string($conn, $_POST['tv']);
$mp1 = mysqli_real_escape_string($conn, $_POST['mp1']);
$mp2 = mysqli_real_escape_string($conn, $_POST['mp2']);
$mp3 = mysqli_real_escape_string($conn, $_POST['mp3']);
$mp4 = mysqli_real_escape_string($conn, $_POST['mp4']);
$st  = mysqli_real_escape_string($conn, $_POST['st']);
$npe = mysqli_real_escape_string($conn, $_POST['npe']);
$numpe = mysqli_real_escape_string($conn, $_POST['numpe']);
$ncr = mysqli_real_escape_string($conn, $_POST['ncr']);
$numcr = mysqli_real_escape_string($conn, $_POST['numcr']);
$nrg  = mysqli_real_escape_string($conn, $_POST['nrg']);
$numrg = mysqli_real_escape_string($conn, $_POST['numrg']);
$nip  = mysqli_real_escape_string($conn, $_POST['nip']);
$numip = mysqli_real_escape_string($conn, $_POST['numip']);

$id = obtenerid("vivienda", "idvivienda");

#Se concatenan las consultas.
$insvivienda  = "insert into vivienda(idvivienda, rol, fojas, anio, numero, anio_recepcion, conservador, tipo,  superficie) ".
			    "values(".$id.", '".$rol."', '".$foj."', ".$ar.", ".$num.", ".$ar.", ".$cv.", ".$tv.", ".$st.");";
$insvivienda .= "insert into persona_vivienda(rol, rut) values('".$rol."', '".$rut."');";
$insvivienda .= "insert into mts(rol,idpiso,metros, idestado_vivienda) values('".$rol."', 1, '".$mp1."', 1);";
$insvivienda .= "insert into mts(rol,idpiso,metros, idestado_vivienda) values('".$rol."', 2, '".$mp2."', 1);";

# Solo puede ser agregado uno de los pisos para ampliación
if (($mp3 > 0) && ($mp4 == 0)) {	
	
	$insvivienda .= "insert into mts(rol,idpiso,metros, idestado_vivienda) values('".$rol."', 1,' ".$mp3."', 2);";
} else if (($mp4 > 0) && ($mp3 == 0)) {

	$insvivienda .= "insert into mts(rol,idpiso,metros, idestado_vivienda) values('".$rol."', 2, '".$mp4."', 2);";
}



$insvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		   		"values('".$rol."', 1, ".$npe.", ".strtotime(fechamy($numpe)).");";
$insvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		        "values('".$rol."', 2, ".$ncr.", ".strtotime(fechamy($numcr)).");";
$insvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		        "values('".$rol."', 3, ".$nrg.", ".strtotime(fechamy($numrg)).");";
$insvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		        "values('".$rol."', 4, ".$nip.", ".strtotime(fechamy($numip)).");";	

$sql = mysqli_multi_query($conn, $insvivienda);

if ($sql) {		
	
	echo "1";	
}else {
	//echo mysqli_error($conn);	
	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/vivienda.php', 'add', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);

?>