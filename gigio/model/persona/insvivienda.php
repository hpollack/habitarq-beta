<?php
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
if($ar > $ac){
	echo "Año de recepción no puede ser posterior";
	exit();
}

$strvivienda = "insert into vivienda(rol, fojas, anio_recepcion, numero, anio, conservador, tipo, superficie) values('".$rol."', '".$foj."', ".$ar.", ".$num.", ".$ac.", ".$cv.", ".$tv.", ".$st.")";
$strrolrut = "insert into persona_vivienda (rol, rut) values('".$rol."', '".$rut."')";
$strpisouno = "insert into mts(rol,idpiso,metros) values('".$rol."', 1, ".$mp1.")";
$vmp2 = ($mp2!='')? $mp2 : 0;
$strpisodos = "insert into mts(rol,idpiso,metros) values('".$rol."', 2, ".$vmp2.")";

//echo $strvivienda."<br>".$strrolrut."<br>".$strpisouno."<br>".$strpisodos;
$sql = mysqli_query($conn, $strvivienda);
if($sql){
	$sql2 = mysqli_query($conn, $strrolrut);
	$sql3 = mysqli_query($conn, $strpisouno);
	$sql4 = mysqli_query($conn, $strpisodos);
	echo "Datos de vivienda ingresados correctamente";
}else{
	echo "Ocurrió un error "
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/vivienda.php', 'add', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);
?>