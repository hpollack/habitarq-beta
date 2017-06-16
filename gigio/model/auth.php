<?php
include_once '../lib/php/libphp.php';
$conn = conectar();
$rut = mysqli_real_escape_string($conn,  $_POST['user']);
$pas = mysqli_real_escape_string($conn, $_POST['pas']);

$r = explode('-', $rut);
$dv = validaDV($r[0]);

if ($r[1] != $dv) {
	echo "2";
	exit();
}

$string = "select * from usuarios where idusuario = '".$rut."'";

//echo $string."<br>";
$sql = mysqli_query($conn, $string);
//echo mysqli_num_rows($sql);
if(mysqli_num_rows($sql)>0){
	while($row = mysqli_fetch_array($sql)){
		if($row[4]===md5($pas)){			
			echo "ok";
			session_start();
			$_SESSION['rut'] = $row[0];
			$_SESSION['usuario'] = $row[1]." ".$row[2];
			$_SESSION['perfil'] = $row[5];

			$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   			   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."login.php', 'login', ".time().");";
	   		mysqli_query($conn, $log);	   
		}else{
			echo mysqli_error($conn);
			//echo "Usuario o clave inválida";
			$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   			   "values('".$rut."','".$_SERVER['REMOTE_ADDR']."', '".url()."login.php', 'error', ".time().");";

			mysqli_query($conn, $log);
			exit();

		}
	}
}else{
	echo "No existe el usuario o no es válido";
}


mysqli_close($conn);

?>