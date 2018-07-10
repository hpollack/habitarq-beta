<?php
/**
 * =======================================================================
 *  INGRESO DE DATOS DE LA CUENTA DEL POSTULANTE.
 * =======================================================================
 * 
 * Este Script permite el ingreso de la cuenta del postulante, comporbando que no exista
 * mas de una cuenta asociada ni a la persona ni al cónyuge, en caso de que sea este el titular
 * 
 * @author Hermannn Pollack
 * @version 1.1: Se agregó un id como entero correlativo, quedando éste como llave primaria.
 * @version 1.2: Se modificó el parámetro de configuración para las ampliaciones (el dato debe ser ingresado manual)
 * 
**/
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

# Id generado 
$id = obtenerid("cuenta", "idcuenta");

/* Datos ingresados desde la vista */
$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$nc  = mysqli_real_escape_string($conn, $_POST['nc']);
$fap = mysqli_real_escape_string($conn, $_POST['fap']);
$ah  = mysqli_real_escape_string($conn, $_POST['ah']);
$sb  = mysqli_real_escape_string($conn, $_POST['sb']);
$asb = mysqli_real_escape_string($conn, $_POST['asb']);

//Si son distintos a Ampliación.
if ($sb == 4) {
	
	$val = traerValorConfig("UfMejoramiento");
} elseif ($sb == 5) {

	$val = traerValorConfig("UFTermico");
} elseif ($sb == 6) {

	$val = traerValorConfig("UFSolar");
} else {

	$val = ($asb != 0) ? $asb : 0;
}

# Suma del ahorro con el valor del subsidio
$td = $ah + $val;

$fecha = fechamy($fap);

# Si el conyuge es el titular de la cuenta
$cy = $_POST['cy'];
$rutc = ($cy == 1) ? $_POST['rcye'] : $rut;

# Se valida que el numero de cuenta no venga vacío
if ($nc == "") {
	# Si viene vacío, sale de la aplicacin y envía el mensaje
	echo "2";
	exit();
}

# String para ingresar los datos en la cuenta
$cuenta = "insert into cuenta (idcuenta, ncuenta, ahorro, subsidio, total, fecha_apertura) values (".$id.", '".$nc."', ".$ah.", ".$val.", ".$td.", ".strtotime($fecha).")";

# String para los datos asociados de la persona y la cuenta
$persona_cuenta = "insert into cuenta_persona(rut_titular, ncuenta, rut_titularc) values('".$rut."','".$nc."', '".$rutc."')";

$sql1 = mysqli_query($conn, $cuenta);

#Se valida el primer insert
if($sql1){

	#Se inserta los datos asociados de la cuenta y la persona
	$sql2 = mysqli_query($conn,$persona_cuenta);
	echo "1";	
}else{

	# Sale de la aplicación y envía el mensaje de error.
	//echo mysqli_error($conn);
	echo "0";
	exit();
}

$log = "insert into log(usuario, ip, url, accion, fecha) ".
	   "values('".$_SESSION['rut']."','".$_SERVER['REMOTE_ADDR']."', '".url()."view/persona/cuenta.php', 'add', ".time().");";

mysqli_query($conn, $log);

mysqli_close($conn);

?>