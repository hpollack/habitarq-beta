<?php
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
//Datos personales.
$rut = mysqli_real_escape_string($conn, $_POST['rut']);
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
if(isset($vp)){
	$vp = 1;
}else{
	$vp = 0;
}

$pers = "update persona set nombres = '".$nom."', paterno = '".$ap."', materno = '".$am."', correo = '".$mail."', estado = ".$vp." where rut = '".$rut."';";
$ubic = "update direccion set calle = '".$dir."', numero = ".$nd.", idcomuna = ".$cm." WHERE rutpersona = '".$rut."'";
$tel  = "update fono set numero = ".$tf.", tipo = ".$tp." WHERE rutpersona = '".$rut."'";

$sql_pers = mysqli_query($conn, $pers);
if(!$sql_pers){
	echo "Error al actualizar persona: ".mysqli_error($conn);
	exit();
}
$sql_ubic = mysqli_query($conn, $ubic);
if(!$sql_ubic){
	echo "Error al actualizar direccion: ".mysqli_error($conn);
	exit();
}
$sql_tel = mysqli_query($conn, $tel);
if(!$sql_tel){
	echo "Error al actualizar telefono: ".mysqli_error($conn);
	exit();
}

echo "Información actualizada";

?>