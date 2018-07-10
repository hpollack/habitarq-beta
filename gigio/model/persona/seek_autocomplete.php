<?php 
/**
 * =================================================================
 *  SCRIPT PARA AUTOCOMPLETADO DE SUGERENCIA EN CAMPO RUT
 * =================================================================
 * 
 * Muestra el nombre de la persona con el rut asociado mientras va ecribiendo
 * en el campo de busqueda de los submódulos de persona. 
 * 
 * Se puede pulsar sobre el nombre de la persona deseada y buscar en la lista
 * que se va desplegando.
 * 
 * @author Hermann Pollack
 * @version 1.0
 * 
 * @param string $rut: el rut de la persona
 * @return una lista con las sugerencias (que se reducirán a medida que se complete el campo)
 * 
 **/
session_start();
include_once '../../lib/php/libphp.php';

$rutus = $_SESSION['rut'];
$perfil = $_SESSION['perfil'];

if(!$rutus){
	echo "No puede ver esta pagina";
	header("location: ".url()."/login.php");
	exit();
}

$conn = conectar();

//Se verifica que venga algo
$rut = $_POST['rut'];
if(!isset($rut)) {
	
	exit();
}

# String de la consulta
$string =   "select rut, nombres, concat(paterno,' ', materno) as apellidos from persona where rut like '%".$rut."%' and estado = 1";


$sql = mysqli_query($conn, $string);

# Se verifica que lo resultados sean mayores a cero
if (mysqli_num_rows($sql)>0) {
	# Se cargan los resultados y se van mostrando las sugerencias
	# Aumentan o disminuyen, de acuerdo a medida que se complete el campo.
	while ($f = mysqli_fetch_array($sql)) {
		echo "<div class='element'><a data='".$f[0]."' id='".$f[0]."'>".$f[0]."".
			 "<br><p>".$f[1]." ".$f[2]."</p></a>".
			 "</div>";
	}
} else {
	echo "<p>No hay sugerencias<p>";
}

mysqli_free_result($sql);
mysqli_close($conn);

?>