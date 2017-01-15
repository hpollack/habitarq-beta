<?php 
/*
============================================================
Actualizar datos contratistas
============================================================
*/

session_start();
include_once '../../lib/php/libphp.php';

$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$dv  = mysqli_real_escape_string($conn, $_POST['dv']);
$nom = mysqli_real_escape_string($conn, $_POST['nom']);
$ape = mysqli_real_escape_string($conn, $_POST['ape']);
$dir = mysqli_real_escape_string($conn, $_POST['dir']);
$tel = mysqli_real_escape_string($conn, $_POST['tel']);
$cm  = $_POST['cm'];
$em  = mysqli_real_escape_string($conn, $_POST['em']);
$crg = mysqli_real_escape_string($conn, $_POST['crg']);


//Valida el digito verificador
$rdv = validaDV($rut);

//Si son distintos
if($dv!=$rdv){
	echo "no";
	exit();
}

$string = "update profesionales".
		  "SET nombres = '".$nom."', apellidos = '".$ape."', direccion = '".$dir."', ".
		  "idcomuna = ".$cm.", telefono = ".$tel.", correo = '".$em."', cargo = '".$crg"' ".
		  "WHERE rutprof = '".$rut."'";

$sql = mysqli_query($conn, $string);

if($sql){
	echo "1";
}else{
	echo "0";
}


 ?>