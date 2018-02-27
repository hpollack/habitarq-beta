<?php 
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}

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

	$string = "insert into profesionales(rutprof, dv, nombres, apellidos, direccion, idcomuna, telefono, correo, cargo, estado)".
			  " VALUES('".$rut."', '".$dv."', '".$nom."', '".$ape."', '".$dir."', ".$cm.", ".$tel.", '".$em."', '".$crg."', 1)";

	$sql = mysqli_query($conn, $string);

	if ($sql) {
		echo "1";

		$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/contratistas/index.php', 'add', ".time().");";

		mysqli_query($conn, $log);
	}else{
		echo "0";
		exit();

		$log = "insert into log(usuario, ip, url, accion, fecha) ".
		   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/contratistas/index.php', 'error add', ".time().");";

	mysqli_query($conn, $log);
	}
}

mysqli_close($conn);

 ?>