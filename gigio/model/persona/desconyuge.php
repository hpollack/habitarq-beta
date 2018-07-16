<?php 
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
$rut = $_POST['rutp'];
if (!isset($rut)) {
	
	//$string = "update conyuge set estado = 0 where rutpersona = '".$rut."'";
	echo "0";
	exit();
}

$string = "update conyuge set estado = 0 where rutpersona = '".$rut."'";
$sql = mysqli_query($conn, $string);

if ($sql) {
	
	//See busca la ficha asociada al rut
	$sql2 = mysqli_query($conn,"select nficha from persona_ficha where rutpersona = '".$rut."'");
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
		$cambios .= "update cuenta_persona set rut_titularc = '".$rut."' where rut_titular = '".$rut."'";

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