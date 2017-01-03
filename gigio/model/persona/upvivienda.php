<?php
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
$rut = $_POST['rut'];
$rol = $_POST['rol'];
$foj = $_POST['foj'];
$ar  = $_POST['ar'];
$mp1 = $_POST['mp1'];
$mp2 = $_POST['mp2'];
$ac  = $_POST['ac'];
$tv  = $_POST['tv'];
$st  = $_POST['st'];
$cv  = $_POST['cv'];
$num = $_POST['num'];
$id  = $_POST['idr'];
if($ar > $ac){
	echo "Año de recepción no puede ser posterior";
	exit();
}

$strvivienda = "update vivienda SET anio_recepcion = ".$ar.", fojas = '".$foj."',
anio = ".$ac.", numero = ".$num.", conservador = ".$cv.", tipo = ".$tv.", superficie = ".$st." where rol = '".$rol."'";
$strrolrut = "update  persona_vivienda set rol = '".$rol."', rut = '".$rut."' where idpersona_vivienda = ".$id."";
$strpiso1 = "update mts set metros = ".$mp1." where rol = '".$rol."' and idpiso = 1";
$strpiso2 = "update mts set metros = ".$mp2." where rol = '".$rol."' and idpiso = 2";

//echo $strvivienda."<br>".$strrolrut."<br>".$strpiso1."<br>".$strpiso2;
$sql = mysqli_query($conn, $strvivienda);
if($sql){
	$sql2 = mysqli_query($conn, $strrolrut);
	$sql3 = mysqli_query($conn, $strpiso1);
	$sql4 = mysqli_query($conn, $strpiso2);
	echo "Datos actualizados";
}else{
	echo "Ocurrio un error: ".mysqli_error($conn);
	exit();
}

?>