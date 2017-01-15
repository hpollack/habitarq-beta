<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$dv  = mysqli_real_escape_string($conn, $_POST['dv']);
$nom = mysqli_real_escape_string($conn, $_POST['nom']);
$ape = mysqli_real_escape_string($conn, $_POST['ape']);
$dir = mysqli_real_escape_string($conn, $_POST['dir']);
$tel = mysqli_real_escape_string($conn, $_POST['tel']);
$cm  = $_POST['cm'];
$em  = mysqli_real_escape_string($conn, $_POST['em']);
$crg = mysqli_real_escape_string($conn, $_POST['crg']);

$str = mysqli_query($conn, "select rut from persona where rut = '".$rut."'");
$existeRut = mysqli_fetch_row($str);

//Consulta si existe en la nomina de personas. De existir, envia un aviso
if($existeRut[0]){
	echo "2";
	exit();
}else{

	$rdv = validaDV($rut);


	//Si el digito no es valido, envia mensaje 
	if($dv != $rdv){
		echo "no";
		exit();
	}

	$string = "insert into profesionales(rutprof, dv, nombres, apellidos, direccion, idcomuna, telefono, correo, cargo)".
			  " VALUES('".$rut."', '".$dv."', '".$nom."', '".$ape."', '".$dir."', ".$cm.", ".$tel.", '".$em."', '".$crg."')";

	$sql = mysqli_query($conn, $string);

	if ($sql) {
		echo "1";
	}else{
		echo "0";
		exit();
	}
}

mysqli_close($conn);

 ?>