<?php 
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
$rut = explode("-", $_GET['r'], -1);

$string = "update persona set estado = 0 where rut ='".$rut[0]."'";
$sql = mysqli_query($conn, $string);
if($sql){
	echo "1";
}else{
	echo "0";
}

?>