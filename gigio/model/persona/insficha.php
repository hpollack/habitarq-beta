<?php
session_start();
date_default_timezone_set("America/Santiago");
include_once '../../lib/php/libphp.php';
$conn = conectar();

$rut = mysqli_real_escape_string($conn, $_POST['rut']);
$ec  = mysqli_real_escape_string($conn, $_POST['ec']);
$fnac = mysqli_real_escape_string($conn, $_POST['fnac']);
$tmo = mysqli_real_escape_string($conn, $_POST['tmo']);
$pnt = mysqli_real_escape_string($conn, $_POST['pnt']);
$dh  = mysqli_real_escape_string($conn, $_POST['dh']);
$gfm = mysqli_real_escape_string($conn, $_POST['gfm']);
$adm = (isset($_POST['adm']))? 1 : 0;
$ds =  (isset($_POST['ds']))? 1 : 0;
$ch = $_POST['ch'];

$fecha = fechamy($fnac);

$string = "insert into frh (idestadocivil, fecha_nacimiento, tramo, puntaje, deficit, nucleo_familiar, adultomayor, discapacidad)
values(".$ec.", ".strtotime($fecha).", ".$tmo.", ".$pnt.", ".$dh.", ".$gfm.", ".$adm.", ".$ds.")";

$sql = mysqli_query($conn, $string);

$id = mysqli_insert_id($conn);
$sql2 = mysqli_query($conn, "insert into persona_ficha(rutpersona, nficha) values('".$rut."', ".$id.")");
/*Insertar factores */
$traeFactores = mysqli_query($conn, "select * from factores_carencia");
if($traeFactores){
	while ($f=mysqli_fetch_array($traeFactores)){
		$insertFactores = "insert into ficha_factores(nficha, factor, valor) values(".$id.", ".$f[0].", 0)";
		mysqli_query($conn, $insertFactores);
	}
}
/*Actualiza factores checkeados*/
if(isset($ch)){
	if(is_array($ch)){		
		//$num = count($ch);
		foreach ($ch as $k => $v) {
			$actualizaFactores = "update ficha_factores set valor = 1 where nficha = ".$id." and factor = ".$v."";
			mysqli_query($conn, $actualizaFactores);
		}
	}
}
echo "Datos Agregados";


?>