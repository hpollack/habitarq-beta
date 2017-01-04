<?php
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']);

$string1 = "select CONCAT(p.rut,'-', p.dv) as RUT, p.nombres as Nombre, concat(p.paterno,' ',p.materno) as Apellidos ".
			"FROM persona AS p WHERE rut = '".$rut."' and p.estado = 1";

$sql = mysqli_query($conn, $string1);

if(mysqli_num_rows($sql) > 0){
	while($f = mysqli_fetch_array($sql)){
		echo "<label class='col-md-4 control-label'>RUT: </label><p class='col-md-5'>".$f[0]."</p>";
		echo "<label class='col-md-4 control-label'>Nombres: </label><p class='col-md-5'>".$f[1]."</p>";
		echo "<label class='col-md-4 control-label'>Apellidos: </label><p class='col-md-5'>".$f[2]."</p>";		
	}
}else{
	echo "<p class='text text-danger text-center' ><strong>Esta persona no existe en la base de datos</p>";
}

?>