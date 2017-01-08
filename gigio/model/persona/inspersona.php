<?php
session_start();
include_once '../../lib/php/libphp.php';
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

$dvr = validaDV($rut);
if($dv!=$dvr){
	echo "2";
	exit();
}


$pers = "insert into persona (rut, dv, nombres, paterno, materno, correo) values('".$rut."', '".$dv."', '".$nom."', '".$ap."', '".$am."', '".$mail."')";
$ubic = "insert into direccion (calle, numero, idcomuna, rutpersona) values('".$dir."', ".$nd.", ".$cm.", '".$rut."')";
$tel = "insert into fono (numero, tipo, rutpersona) values (".$tf.", ".$tp.", '".$rut."')";

$sql_pers = mysqli_query($conn, $pers);
if(!$sql_pers){
	echo "0";
	exit();
}
$sql_dir = mysqli_query($conn, $ubic);
if(!$sql_dir){
	echo "0";
	exit();
}
$sql_tel = mysqli_query($conn, $tel);
if(!$sql_tel){
	echo "0";	
	exit();
}
echo "1";

?>