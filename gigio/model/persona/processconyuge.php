<?php  

/**
* DATOS DEL CONYUGE.
* Estos datos se cargarán en el form de la ventana modal.
* @author Hermann Pollack
**/
session_start();
include_once '../../lib/php/libphp.php';
$url = url();
$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];
if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".$url."login.php");
	exit();
}

$conn = conectar();

$rut = $_POST['rut'];
$rutp = $_POST['rp'];

if (isset($rut)) {
	# code...
	$where = "where rutconyuge = '".$rut."' and rutpersona = '".$rutp."'";
} else {

	$where = "where rutpersona = '".$rutp."'";
}


$str = "select rutconyuge, dv, nombres, paterno, materno, sexo, estado, rutpersona from conyuge $where";
//echo $str; exit();
$ex = mysqli_query($conn, $str);

$result = mysqli_num_rows($ex);

if ($fx = mysqli_fetch_array($ex)) {

	if ($fx[6] == 0) {
		# Si el estado tiene valor 0, no devuelve los datos
		$r = null;
		$d = null;
		$n = null;
		$p = null;
		$m = null;
		$s = null;
		$v = null;
		$rp = $rutp;
	} else {

		$r = $fx[0];
		$d = $fx[1];
		$n = $fx[2];
		$p = $fx[3];
		$m = $fx[4];
		$s = $fx[5];
		$v = $fx[6];
		$rp = $fx[7];
	}

	
}else {	

	$r = null;
	$d = null;
	$n = null;
	$p = null;
	$m = null;
	$s = null;
	$v = null;
	$rp = $rutp;
}

if ($ex) {
	# code...

	$datos = array('rutc' => $r , 'dvc' => $d, 'nomc' => $n,
	 'apc' => $p, 'amc' => $m, 'sx' => $s, 'vpc' => $v, 'rutp' => $rp );

	echo json_encode($datos);
}else {
	echo "Error";
	exit();
}

mysqli_close($conn);
?>