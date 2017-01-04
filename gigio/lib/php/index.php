<?php 
session_start();
if(!$_SESSION['rut']){
	echo "No puede ver esta pagina";
	header("location: ".$url."login.php");
	exit();
}
?>