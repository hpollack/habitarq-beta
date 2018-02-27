<?php
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
//Datos personales.
$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$dv = mysqli_real_escape_string($conn, $_POST['dv']);
$nom =mysqli_real_escape_string($conn, $_POST['nom']);
$ap = mysqli_real_escape_string($conn, $_POST['ap']);
$am = mysqli_real_escape_string($conn, $_POST['am']);
$vp = mysqli_real_escape_string($conn, $_POST['vp']);
//Datos Direccion.
$dir = mysqli_real_escape_string($conn, $_POST['dir']);
$nd = mysqli_real_escape_string($conn, $_POST['nd']);
$reg = mysqli_real_escape_string($conn, $_POST['reg']);
$pr = mysqli_real_escape_string($conn, $_POST['pr']);
$cm = mysqli_real_escape_string($conn, $_POST['cm']);
$mail = mysqli_real_escape_string($conn, $_POST['mail']);
$tf = mysqli_real_escape_string($conn, $_POST['tf']);
$tp = mysqli_real_escape_string($conn, $_POST['tp']);
$loc = mysqli_real_escape_string($conn, $_POST['loc']);

if(isset($vp)){
	
	$vp = 1;
}else{
	
	$vp = 0;
}

$dvr = validaDV($rut);

if($dv!=$dvr){
	# Si el digito no es correcto, manda mensaje de error.
	echo "2";
	exit();
}

if ($mail == "") {

	# Mail por defecto, si no viene nada en el campo.
	$mail = 'entidadpatrocinadorahabitarq@gmail.com';
}

# Para verificar si no tiene una direccion y/o teléfono existente en la base de datos. 

$d = mysqli_fetch_row(mysqli_query($conn, "select rutpersona from direccion where rutpersona = '".$rut."'"));
$t = mysqli_fetch_row(mysqli_query($conn, "select rutpersona from fono where rutpersona = '".$rut."'"));

$pers = "update persona set nombres = '".$nom."', paterno = '".$ap."', materno = '".$am."', correo = '".$mail."', estado = ".$vp." where rut = '".$rut."';";

if($d[0] == "") {
	# Si no existe dirección, se crea
	$ubic = "insert into direccion (calle, numero, idcomuna, localidad, rutpersona) values('".$dir."', ".$nd.", ".$cm.", '".$loc."', '".$rut."')";
}else {
	# Se actualiza el campo.
	$ubic = "update direccion set calle = '".$dir."', numero = ".$nd.", idcomuna = ".$cm.", localidad = '".$loc."' WHERE rutpersona = '".$rut."'";

}

if ($t[0] == "") {
	# Idem a lo anterio, pero esta vez con el fono.
	$tel = "insert into fono (numero, tipo, rutpersona) values (".$tf.", ".$tp.", '".$rut."')";	
}else {
	#Se actualiza el campo
	$tel  = "update fono set numero = ".$tf.", tipo = ".$tp." WHERE rutpersona = '".$rut."'";
}

// Se ejecutan las sentencias SQL.

$sql_pers = mysqli_query($conn, $pers);

if(!$sql_pers){
	# Mensaje de error y registro en el log.
	# igual que en las siguientes
	echo "0";
	
	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/ficha.php', 'error add', ".time().");";

	mysqli_query($conn, $log);

	exit();
}

$sql_dir = mysqli_query($conn, $ubic);

if(!$sql_dir){
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/ficha.php', 'error add', ".time().");";

	mysqli_query($conn, $log);

	exit();
}
$sql_tel = mysqli_query($conn, $tel);
if(!$sql_tel){
	echo "0";

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/ficha.php', 'error add', ".time().");";

	mysqli_query($conn, $log);

	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/persona.php', 'update', ".time().");";

mysqli_query($conn, $log);

echo "1";

mysqli_close($conn);
?>