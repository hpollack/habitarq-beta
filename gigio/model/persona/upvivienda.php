<?php

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
$id  = $_POST['idr'];

$strvivienda = "update vivienda SET rol = '".$rol."', anio_recepcion = ".$ar.", anio = ".$ar.", fojas = '".$foj."', ".
" numero = ".$num.", conservador = ".$cv.", tipo = ".$tv.", superficie = '".number_format($st, 2, '.', '')."' where rol = '".$rol."';";
$strvivienda .= "update persona_vivienda set rut = '".$rut."' where idpersona_vivienda = ".$id.";";
$strvivienda .= "update mts set rol ='".$rol."', metros = '".$mp1."' where rol = '".$rol."' and idpiso = 1 and idestado_vivienda = 1;";
$strvivienda .= "update mts set rol ='".$rol."', metros = '".$mp2."' where rol = '".$rol."' and idpiso = 2 and idestado_vivienda = 1;";

if (($mp3 > 0) && ($mp4 == 0)) {
	
	$strvivienda .= "update mts set rol ='".$rol."', metros =' ".$mp3."' where rol = '".$rol."' and idpiso = 1 and idestado_vivienda = 2;";
} else if (($mp4 > 0) && ($mp3 == 0)) {
	
	$strvivienda .= "update mts set rol ='".$rol."', metros =' ".$mp4."' where rol = '".$rol."' and idpiso = 2 and idestado_vivienda = 2;";
} 

// Verifico si existen ingresados los certificados.
$cert1 = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda_certificados where idcertificacion = 1 and rol = '".$rol."'"));
$cert2 = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda_certificados where idcertificacion = 2 and rol = '".$rol."'"));
$cert3 = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda_certificados where idcertificacion = 3 and rol = '".$rol."'"));
$cert4 = mysqli_fetch_row(mysqli_query($conn, "select rol from vivienda_certificados where idcertificacion = 4 and rol = '".$rol."'"));

if ($cert1[0] == "") {
	# code...
	$strvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		   		    "values('".$rol."', 1, ".$npe.", ".strtotime(fechamy($numpe)).");";
} else {

	$strvivienda .= "update vivienda_certificados set rol ='".$rol."', numero = ".$npe.", fecha = ".strtotime(fechamy($numpe))." ".
				    "where rol = '".$rol."' and idcertificacion = 1;";
}
if ($cert2[0] == "") {
	# code...
	$strvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		   		    "values('".$rol."', 2, ".$ncr.", ".strtotime(fechamy($numcr)).");";
} else {
	# code...
	$strvivienda .= "update vivienda_certificados set rol ='".$rol."', numero = ".$ncr.", fecha = ".strtotime(fechamy($numcr))." ".
				    "where rol = '".$rol."' and idcertificacion = 2;";
}

if ($cert3[0] == "") {
	
	$strvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		            "values('".$rol."', 3, ".$nrg.", ".strtotime(fechamy($numrg)).");";
} else {

	$strvivienda .= "update vivienda_certificados set rol ='".$rol."', numero = ".$nrg.", fecha = ".strtotime(fechamy($numrg))." ".
				    "where rol = '".$rol."' and idcertificacion = 3;";		
}

if ($cert4[0] == "") {
	
	$strvivienda .= "insert into vivienda_certificados(rol, idcertificacion, numero, fecha) ".
		            "values('".$rol."', 4, ".$nip.", ".strtotime(fechamy($numip)).");";	
} else {
	
	$strvivienda .= "update vivienda_certificados set rol ='".$rol."', numero = ".$nip.", fecha = ".strtotime(fechamy($numip))." ".
				    "where rol = '".$rol."' and idcertificacion = 4;";
}

//echo number_format($mp1, 2, '.',','); exit();
$sql = mysqli_multi_query($conn, $strvivienda);
if($sql){	

	echo "1";
	
}else{
	//echo mysqli_error($conn);
	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/vivienda.php', 'update', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);

?>