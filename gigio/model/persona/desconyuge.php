<?php 
/**
 * ======================================================
 * CAMBIAR ESTADO REGISTRO DE CONYUGE
 * ======================================================
 * Este script, cambia el estado del conyuge de 1 a 0. La razón para hacerlo es que
 * puede ser reutilizados en caso de pérdida de datos. Al desactivar, no aparecerá vinculado
 * Al beneficiario en la ficha (cambio de estado civil) ni a las cuentas (se reasigna el rut al titular)
 * 
 * @version 1.0
 * @param rutp (string) rut beneficiario
 * @param  rut (string) rut conyuge
 * @return 1 si es exitoso o 0 si hay algun error.
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
$rut = $_POST['rutc'];
$rutp = $_POST['rutp'];

if (!isset($rut)) {
	
	echo "0";
	exit();
}

/* 
  	Se procede a modificar el registro: se cambia el estado y se borra
  	el rut del beneficiario al que esta asociado
*/
$string = "update conyuge set estado = 0, rutpersona = '' where rutconyuge = '".$rut."'";
$sql = mysqli_query($conn, $string);

if ($sql) {
	
	//See busca la ficha asociada al rut del beneficiario
	$sql2 = mysqli_query($conn,"select nficha from persona_ficha where rutpersona = '".$rutp."'");
	if ($sql2) {
		// se extrae el numero de ficha para cambiar el estado civil
		$f = mysqli_fetch_row($sql2);
		/* 
			Se cambia el estado civil y en caso de estar asociada la cuenta al conyuge,
			se cambia por el rut del beneficiario.
			Nota: en caso de regresar a usar el mismo conyuge, se debe actualizar en el modulo cuenta
			(por defecto viene marcado con un check)
		*/
		$cambios  = "update frh set idestadocivil = 0 where nficha = ".$f[0].";";
		$cambios .= "update cuenta_persona set rut_titularc = '".$rutp."' where rut_titular = '".$rutp."'";

		mysqli_multi_query($conn, $cambios);
	} else {

		//echo mysqli_error($conn);
		//De ocurrir un error, termina el programa.
		exit();
	}

	echo "1";
	insLog($rutus,$url."view/persona/ficha.php","del");
} else {

	echo "0";
	insLog($rutus,$url."view/persona/ficha.php"," error del");

}

mysqli_close($conn);

?>