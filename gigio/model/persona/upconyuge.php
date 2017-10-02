<?php  
session_start();
include_once '../../lib/php/libphp.php';

date_default_timezone_set("America/Santiago");


$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
$nombre = $_SESSION['usuario'];

if(!$rutus){
    echo "No puede ver esta pagina";
    header("location: ".url()."login.php");
    exit();
}

$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rutc']);
$dv  = mysqli_real_escape_string($conn, $_POST['dvc']);
$nom = mysqli_real_escape_string($conn, $_POST['nomc']);
$pat = mysqli_real_escape_string($conn, $_POST['apc']);
$mat = mysqli_real_escape_string($conn, $_POST['amc']);
$sx  = $_POST['sx'];

$post = $_POST['rutp'];

$rutexist = mysqli_fetch_row(mysqli_query($conn, "select count(rut) from persona where rut = '".$rut."'"));
//$conexist = mysqli_fetch_row(mysqli_query($conn, "select rutconyuge from conyuge where rutconyuge = '".$rut."' or rutpersona = '".$rut."'"));

if ($rutexist[0] > 0) {
	#Si existe entonces no se agrega. Se genera el mensaje al controlador
	echo "2";
	exit();
}

$dvr = validaDV($rut);

if ($dv != $dvr) {
	# Si es distinto el digito ingresado sale del programa y envia mensaje de error
	echo "3";
	exit();
}

// if ($conexist[0]) {
// 	#Si existe el conyuge.
// 	echo "4";
// 	exit();
// }

$string = "update conyuge set rutconyuge = '".$rut."', dv = '".$dv."', nombres = '".$nom."', ".
		  "paterno = '".$pat."', materno = '".$mat."', sexo = '".$sx."' where rutpersona = '".$post."'";

$sql = mysqli_query($conn, $string);

if ($sql) {
	# code...
	echo "1";
}else {

	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/comite/comite.php', 'update', ".time().");";
mysqli_query($conn, $log);


mysqli_close($conn);
?>