<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$nom = mysqli_real_escape_string($conn, $_POST['nom']);
$ape = mysqli_real_escape_string($conn, $_POST['ape']);
$dir = mysqli_real_escape_string($conn, $_POST['dir']);
$tel = mysqli_real_escape_string($conn, $_POST['tel']);
$cm  = $_POST['cm'];
$em  = mysqli_real_escape_string($conn, $_POST['em']);
$crg = mysqli_real_escape_string($conn, $_POST['crg']);

$str = mysqli_query($conn, "select rut from persona where rut = '".$rut."'");
$existeRut = mysqli_fetch_row($str);

if($existeRut[0]){
	echo "2";
	exit();
}else{
	
	$string = "insert into profesionales(rutprof, nombres, apellidos, direccion, idcomuna, telefono, correo, cargo)".
			  " VALUES('".$rut."', '".$nom."', '".$ape."', '".$dir."', ".$cm.", ".$tel.", '".$em."', '".$crg."')";

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