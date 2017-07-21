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



$dvr = validaDV($rut);
if($dv!=$dvr){
	echo "2";
	exit();
}

if ($mail == "") {
	$mail = 'entidadpatrocinadorahabitarq@gmail.com';
}


$pers = "insert into persona (rut, dv, nombres, paterno, materno, correo) values('".$rut."', '".$dv."', '".$nom."', '".$ap."', '".$am."', '".$mail."');";
$pers .= "insert into direccion (calle, numero, idcomuna, localidad, rutpersona) values('".$dir."', ".$nd.", ".$cm.", '".$loc."', '".$rut."');";
$pers .= "insert into fono (numero, tipo, rutpersona) values (".$tf.", ".$tp.", '".$rut."');";

//Multiples queries
$sql_pers = mysqli_multi_query($conn, $pers);
if(!$sql_pers){
	echo mysqli_error($conn);

	$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/ficha.php', 'error add', ".time().");";

	mysqli_query($conn, $log);
	
	exit();
}


$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."/view/persona/persona.php', 'add', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);
	   	
echo "1";

?>