<?php
/**
 * ====================================================================
 * ACTUALIZACION DE DATOS DE LA VIVIENDA
 * ====================================================================
 * 
 * Script para actualizar los datos de la vivienda.
 * 
 * @author Hermann Pollack
 * @version 1.1: Se agregó la funcionalidad multiquery
 * @version 1.2: se corrigio la actualizacion de metros y certificados. 
 * En caso de no existir previamente, se genera un string de inserción.
 * @version 1.2.1 Se corrigió variables que no traian valores, 
 * validando inserción en el caso descrito
 * @version 1.3: se agregó una id numérico correlativo a la tabla vivienda, 
 * campo que se trae en la búsqueda y se deja como primary key
 * 
 * @return 1 si es válido o 0 si es incorrecto
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

// Datos a ingresar. Actualizada la tabla para agregar una id a cada fila, la cual servirá para actualizar valores.

$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$rol = mysqli_real_escape_string($conn, $_POST['rol']);
$foj = mysqli_real_escape_string($conn, $_POST['foj']);
$num = mysqli_real_escape_string($conn, $_POST['num']);
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
$idr  = $_POST['idr'];
$id  = $_POST['id'];

// rol anterior. Esto para evitar conflictos a la hora de actualizar.
$r = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda where idvivienda = ".$id."")); 

$strvivienda = "update vivienda SET rol = '".$rol."', anio_recepcion = ".$ar.", anio = ".$ar.", fojas = '".$foj."', ".
" numero = ".$num.", conservador = ".$cv.", tipo = ".$tv.", superficie = '".number_format($st, 2, '.', '')."' where idvivienda = ".$id.";";

$strvivienda .= "update persona_vivienda set rol ='".$rol."', rut = '".$rut."' where idpersona_vivienda = ".$idr.";";
$strvivienda .= "update mts set rol ='".$rol."', metros = '".$mp1."' where rol = '".$r[0]."' and idpiso = 1 and idestado_vivienda = 1;";
$strvivienda .= "update mts set rol ='".$rol."', metros = '".$mp2."' where rol = '".$r[0]."' and idpiso = 2 and idestado_vivienda = 1;";

# Se verifica si existen filas con metros agregados para ampliación
$mt1 = mysqli_fetch_row(mysqli_query($conn, "select rol, metros from mts where rol = '".$r[0]."' and idpiso = 1 and idestado_vivienda = 2"));
$mt2 = mysqli_fetch_row(mysqli_query($conn, "select rol, metros from mts where rol = '".$r[0]."' and idpiso = 2 and idestado_vivienda = 2"));

if ($mt1[0]) {
	
	if($mp3 == "") {

		$strvivienda .= "update mts set rol ='".$rol."', metros =' ".$mp3."' where rol = '".$r[0]."' and idpiso = 1 and idestado_vivienda = 2;";
	}
} else if ($mt2[0]) {
	# code...
	if ($mp4 == "") {
		# code...
		$strvivienda .= "update mts set rol ='".$rol."', metros =' ".$mp4."' where rol = '".$r[0]."' and idpiso = 2 and idestado_vivienda = 2;";	
	}
} else if (!$mt1[0])  {

	if ($mp3 == "") {

		$strvivienda .= "insert into mts(rol,idpiso,metros, idestado_vivienda) values('".$rol."', 1,' ".$mp3."', 2);";
	}
} else if (!$mt2[0]) {

	if ($mp4 == "") {
		
		$strvivienda .= "insert into mts(rol,idpiso,metros, idestado_vivienda) values('".$rol."', 2,' ".$mp4."', 2);";
	}
}

/*if (($mp3 > 0) && ($mp4 == null)) {	
			
	$strvivienda .= "update mts set rol ='".$rol."', metros =' ".$mp3."' where rol = '".$r[0]."' and idpiso = 1 and idestado_vivienda = 2;";
} else if (($mp4 > 0) && ($mp3 == null)) {
	
	$strvivienda .= "update mts set rol ='".$rol."', metros =' ".$mp4."' where rol = '".$r[0]."' and idpiso = 2 and idestado_vivienda = 2;";
}
*/


// Verifico si existen ingresados los certificados.
// Se evaluan de acuerdo al registro devuelto.
$cert1 = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda_certificados where idcertificacion = 1 and rol = '".$r[0]."'"));
$cert2 = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda_certificados where idcertificacion = 2 and rol = '".$r[0]."'"));
$cert3 = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda_certificados where idcertificacion = 3 and rol = '".$r[0]."'"));
$cert4 = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda_certificados where idcertificacion = 4 and rol = '".$r[0]."'"));

if (!$cert1) {
	# Si no hay valor en el certificado uno
	if ($npe) {
		# Si viene un valor, se crea un registro.
		$strvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		   		    "values('".$rol."', 1, ".$npe.", ".strtotime(fechamy($numpe)).");";
	} 	
	
} else {
	# De existir, actualiza los valores.
	$strvivienda .= "update vivienda_certificados set rol ='".$rol."', numero = ".$npe.", fecha = ".strtotime(fechamy($numpe))." ".
				    "where rol = '".$r[0]."' and idcertificacion = 1;";
}
if (!$cert2) {
	
	if($nrc) {

		$strvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		   		        "values('".$rol."', 2, ".$ncr.", ".strtotime(fechamy($numcr)).");";	
	}
	
	
} else {
	
	$strvivienda .= "update vivienda_certificados set rol ='".$rol."', numero = ".$ncr.", fecha = ".strtotime(fechamy($numcr))." ".
				    "where rol = '".$r[0]."' and idcertificacion = 2;";
}

if (!$cert3) {
	
	if ($nrg) {
		
		$strvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		                "values('".$rol."', 3, ".$nrg.", ".strtotime(fechamy($numrg)).");";
	}
	
} else {

	$strvivienda .= "update vivienda_certificados set rol ='".$rol."', numero = ".$nrg.", fecha = ".strtotime(fechamy($numrg))." ".
				    "where rol = '".$r[0]."' and idcertificacion = 3;";		
}

if (!$cert4) {
	
	if ($nip) {

		$strvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		                "values('".$rol."', 4, ".$nip.", ".strtotime(fechamy($numip)).");";	
	} 
	
} else {
	
	$strvivienda .= "update vivienda_certificados set rol ='".$rol."', numero = ".$nip.", fecha = ".strtotime(fechamy($numip))." ".
				    "where rol = '".$r[0]."' and idcertificacion = 4;";
}

//echo number_format($mp1, 2, '.',','); exit();
$sql = mysqli_multi_query($conn, $strvivienda);
if($sql){	

	echo "1";
	
} else {
	//echo mysqli_error($conn);
	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/vivienda.php', 'update', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);

?>