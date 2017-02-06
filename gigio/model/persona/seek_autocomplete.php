<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$rut = $_POST['rut'];
if(!isset($rut)) {
	exit();
}

$string =   "select rut, nombres, concat(paterno,' ', materno) as apellidos from persona where rut like '%".$rut."%' and estado = 1";

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