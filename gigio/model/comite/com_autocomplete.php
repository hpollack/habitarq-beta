<?php 
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

$dato = $_POST['inp'];
if(!isset($rut)) {
	exit();
}

$string =   "select numero, nombre from grupo where numero like '%".$dato."%' or nombre like '%".$dato."%' and estado = 1";

$sql = mysqli_query($conn, $string);

if (mysqli_num_rows($sql)>0) {
	
	while ($f = mysqli_fetch_array($sql)) {
		
		echo "<div class='element'><a data='".$f[0]."' id='".$f[0]."'>".$f[0]."".
			 "<br><p>".$f[1]." ".$f[2]."</p></a>".
			 "</div>";
	}
}else{
	
	echo "No hay sugerencias";
}

mysqli_free_result($sql);
mysqli_close($conn);

?>