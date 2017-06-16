<?php 
session_start();
include_once '../../../lib/php/libphp.php';
if(!$_SESSION['rut']){
	echo "No puede ver esta pagina";
	header("location: ".url()."login.php");
	exit();
}
?>