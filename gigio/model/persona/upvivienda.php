<?php
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$rol = mysqli_real_escape_string($conn, $_POST['rol']);
$foj = mysqli_real_escape_string($conn, $_POST['foj']);
$num = mysqli_real_escape_string($conn, $_POST['num']);
$ac  = mysqli_real_escape_string($conn, $_POST['ac']);
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
if($ar > $ac){
	echo "2";
	exit();
}

$strvivienda = "update vivienda SET anio_recepcion = ".$ar.", fojas = '".$foj."',
anio = ".$ac.", numero = ".$num.", conservador = ".$cv.", tipo = ".$tv.", superficie = ".$st." where rol = '".$rol."';";
$strvivienda .= "update  persona_vivienda set rol = '".$rol."', rut = '".$rut."' where idpersona_vivienda = ".$id.";";
$strvivienda .= "update mts set metros = ".$mp1." where rol = '".$rol."' and idpiso = 1 and idestado_vivienda = 1;";
$strvivienda .= "update mts set metros = ".$mp2." where rol = '".$rol."' and idpiso = 2 and idestado_vivienda = 1;";
$strvivienda .= "update mts set metros = ".$mp3." where rol = '".$rol."' and idpiso = 1 and idestado_vivienda = 2;";
$strvivienda .= "update mts set metros = ".$mp4." where rol = '".$rol."' and idpiso = 2 and idestado_vivienda = 2;";

$strvivienda .= "update vivienda_certificados set numero = ".$npe.", fecha = ".strtotime(fechamy($numpe))." ".
				"where rol = '".$rol."' and idcertificacion = 1;";
$strvivienda .= "update vivienda_certificados set numero = ".$ncr.", fecha = ".strtotime(fechamy($numcr))." ".
				"where rol = '".$rol."' and idcertificacion = 2;";
$strvivienda .= "update vivienda_certificados set numero = ".$nrg.", fecha = ".strtotime(fechamy($numrg))." ".
				"where rol = '".$rol."' and idcertificacion = 3;";	
$strvivienda .= "update vivienda_certificados set numero = ".$nip.", fecha = ".strtotime(fechamy($numip))." ".
				"where rol = '".$rol."' and idcertificacion = 4;";											
//echo $strvivienda."<br>".$strrolrut."<br>".$strpiso1."<br>".$strpiso2;
$sql = mysqli_multi_query($conn, $strvivienda);
if($sql){	
	echo "1";

}else{
	echo mysqli_error($conn);
	//echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/vivienda.php', 'update', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);

?>