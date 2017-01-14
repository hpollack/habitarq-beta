<?php 
session_start();

include_once '../../lib/php/libphp.php';
$conn = conectar();

$rut = explode("-", $_GET['rut'], -1);

//El borrado de estos listados es físico.
$string = "delete from persona_comite where rutpersona = '".$rut[0]."'";
$sql = mysqli_query($conn, $string);

if($sql){
	echo "1";
}else{
	echo "0";
}


 ?>