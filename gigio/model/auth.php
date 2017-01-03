<?php
include_once '../lib/php/libphp.php';
$conn = conectar();
$rut = mysqli_real_escape_string($conn,  $_POST['user']);
$pas = mysqli_real_escape_string($conn, $_POST['pas']);



$string = "SELECT * FROM usuarios WHERE idusuario = '".$rut."'";
//echo $string."<br>";
$sql = mysqli_query($conn, $string);
//echo mysqli_num_rows($sql);
if(mysqli_num_rows($sql)>0){
	while($row = mysqli_fetch_array($sql)){
		if($row[3]===$pas){			
			echo "ok";
			session_start();
			$_SESSION['rut'] = $row[0];
			$_SESSION['usuario'] = $row[1]." ".$row[2];
			$_SESSION['perfil'] = $row[4];			
		}else{
			echo "Usuario o clave inválida";			
		}
	}
}else{
	echo "No existe el usuario o no es válido";
}


?>